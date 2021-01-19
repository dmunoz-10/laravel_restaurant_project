<?php

namespace App\Http\Controllers;

use App\Ingredient;
use Illuminate\Http\Request;
use Session;

class IngredientController extends Controller
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
        $ingredients = Ingredient::orderBy('created_at', 'desc')->paginate(15);
        return view('ingredients.index')->withIngredients($ingredients);

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
        return view('ingredients.create');
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
      $this->validate($request, array( 'name' => 'required|unique:ingredients|max:50',
                                       'provider' => 'required|max:50'));
                
      try {
        $ingredient = new Ingredient();
        $ingredient->name = $request->input('name');
        $ingredient->provider = $request->input('provider');
        $ingredient->save();
        Session::flash('success', 'The ingredient was successfully save');

        return redirect()->route('ingredients.show', $ingredient->id);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      try {
        $ingredient = Ingredient::find($id);
        return view('ingredients.show')->withIngredient($ingredient);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try {
        $ingredient = Ingredient::find($id);
        return view('ingredients.edit')->withIngredient($ingredient);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, array( 'name' => 'required|max:50',
                                       'provider' => 'required|max:50'));
      try {
        $ingredient = Ingredient::find($id);
        $ingredient->name = $request->input('name');
        $ingredient->provider = $request->input('provider');
        $ingredient->save();
        Session::flash('success', 'The ingredient was successfully update');

        return redirect()->route('ingredients.show', $ingredient->id);

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try {
        $ingredient = Ingredient::find($id);
        $name = $ingredient->name;
        $ingredient->delete();
        Session::flash('success', 'The ingredient ' . $name . ' was successfully delete');

        return redirect()->route('ingredients.index');

      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }
}
