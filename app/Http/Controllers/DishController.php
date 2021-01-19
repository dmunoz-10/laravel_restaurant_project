<?php

namespace App\Http\Controllers;

use App\Dish;
use App\Ingredient;
use Illuminate\Http\Request;
use Session;

class DishController extends Controller
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
        $dishes = Dish::orderBy('created_at', 'desc')->paginate(15);
        return view('dishes.index')->withDishes($dishes);

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
        $ingredients = Ingredient::all();
        return view('dishes.create')->withIngredients($ingredients);

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
      $this->validate($request, array( 'name' => 'required|unique:dishes|max:50',
                                       'price' => 'required|integer|min:1|max:9999999999' ));
      try {
        $dish = new Dish();
        $dish->name = $request->input('name');
        $dish->price = $request->input('price');
        $dish->save();

        if (!empty($request->input('ingredients'))) {
          $ingredients = $request->input('ingredients');
          foreach (explode(',', $ingredients) as $ingredient) {
            $temp = explode('-', $ingredient);
            $dish->ingredients()->attach($temp[0], ['quantity' => $temp[1]]);
          }
        }
        Session::flash('success', 'The dish was successfully save');
        return redirect()->route('dishes.show', $dish->id);

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
        $dish = Dish::find($id);
        $ingredients = $dish->ingredients()->getResults();
        return view('dishes.show')->withDish($dish)->withIngredients($ingredients);

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
        $dish = Dish::find($id);
        $ingredients = Ingredient::all();
        $itsIngredients = $dish->ingredients()->getResults();
        return view('dishes.edit')->withDish($dish)
                                  ->withIngredients($ingredients)
                                  ->withItsIngredients($itsIngredients);

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
      $this->validate($request, array( 'name' => 'required|max:50',
                                       'price' => 'required|integer|min:1|max:9999999999' ));
      try {
        $dish = Dish::find($id);
        $dish->name = $request->input('name');
        $dish->price = $request->input('price');
        $dish->save();

        if (!empty($request->input('ingredients'))) {
          $ingredients = explode(',', $request->input('ingredients'));
          $ingredients_to_sync = [];
          foreach ($ingredients as $ingredient) {
            $temp = explode('-', $ingredient);
            $ingredients_to_sync[$temp[0]] = ['quantity' => $temp[1]];
          }
          $dish->ingredients()->sync($ingredients_to_sync);
        } else {
          $dish->ingredients()->detach();
        }
        Session::flash('success', 'The dish was successfully update');

      } catch (\Exception $e) {
        return $e->getMessage();
      }

      return redirect()->route('dishes.show', $dish->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try{
        $dish = Dish::find($id);
        $ingredients = $dish->ingredients()->getResults();
        foreach ($ingredients as $ingredient) {
          $dish->ingredients()->detach($ingredient->id);
        }
        $name = $dish->name;
        $dish->delete();
        Session::flash('success', 'The dish ' . $name . ' was successfully delete');

      } catch (\Exception $e) {
        return $e->getMessage();
      }

      return redirect()->route('dishes.index');
    }
}
