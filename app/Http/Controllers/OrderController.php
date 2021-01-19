<?php

namespace App\Http\Controllers;

use App\Order;
use App\Dish;
use DB;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      try {
        $orders = Order::orderBy('created_at', 'desc')->paginate(15);
        return view('orders.index')->withOrders($orders);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      try {
        $dishes = Dish::all();
        return view('orders.create')->withDishes($dishes);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, array( 'tableNumber' => 'required|integer|min:1' ));
      $table_Number = $request->input('tableNumber');
      if (!empty(Order::where(['table_number' => $table_Number,
                               'status' => 'N'])->get()[0])) {
        Session::flash('error', "There are an active order in this table. Choose other table");
        return redirect()->route('orders.create');
      }
      try {
        $order = new Order();
        $order->table_number = $table_Number;
        $order->save();

        if (!empty($request->input('dishes'))) {
          $dishes = $request->input('dishes');
          foreach (explode(',', $dishes) as $dish) {
            $temp = explode('-', $dish);
            $order->dishes()->attach($temp[0],
                                    ['quantity' => (int)$temp[1],
                                     'amount' => (int)$temp[2] * (int)$temp[1]]);
          }
        }

        Session::flash('success', 'The order was successfully save');
        return redirect()->route('orders.show', $order->id);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $order = Order::find($id);
        $dishes = $order->dishes()->getResults();
        $order->total_amount = $order->dishes()->sum('amount');
        return view('orders.show')->withOrder($order)
                                  ->withDishes($dishes);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try {
        $order = Order::find($id);
        $dishes = Dish::all();
        $itsDishes = $order->dishes()->getResults();
        return view('orders.edit')->withOrder($order)
                                  ->withDishes($dishes)
                                  ->withItsDishes($itsDishes);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, array( 'tableNumber' => 'required|integer|min:1' ));

      try {
        $order = Order::find($id);
        $order->table_number = $request->input('tableNumber');
        $order->save();

        if (!empty($request->input('dishes'))) {
          $dishes = explode(',', $request->input('dishes'));
          $dishes_to_sync = [];
          foreach ($dishes as $dish) {
            $temp = explode('-', $dish);
            $dishes_to_sync[$temp[0]] = ['quantity' => $temp[1],
                                         'amount' => (int)$temp[2] * (int)$temp[1]];
          }
          $order->dishes()->sync($dishes_to_sync);
        } else {
          $order->dishes()->detach();
        }

        Session::flash('success', 'The order was successfully update');
        return redirect()->route('orders.show', $order->id);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Close the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($id)
    {
      try {
        $order = Order::find($id);
        $order->update(['status' => 'S']);
        Session::flash('success', 'The order was successfully close');
        return redirect()->route('orders.show', $order->id);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $order = Order::find($id);
        $dishes = $order->dishes()->getResults();
        foreach ($dishes as $dish) {
          $order->dishes()->detach($dish->id);
        }
        $order->delete();
        Session::flash('success', 'The order ' . $id . ' was successfully delete');
        return redirect()->route('orders.index');

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for search a order list per day.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
      try {
        return view('orders.list');

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the specified order list per day.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function orderList(Request $request)
    {
      $this->validate($request, array( 'date' => 'required|date|before_or_equal:today' ));

      try {
        $date = $request->input('date');
        $orders = DB::table('orders')->whereDate('created_at', $date)->get();
        $total_amount = 0;
        foreach ($orders as $order) {
          $order->amount = Order::find($order->id)->dishes()->sum('amount');
          $total_amount += $order->amount;
        }
        $orders->total_amount = $total_amount;
        return view('orders.list')->withOrders($orders)
                                  ->withDate($request->input('date'));

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }
}
