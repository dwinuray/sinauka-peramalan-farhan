<?php

namespace App\Http\Controllers;

use App\Models\Bahanbaku;
use App\Models\Ingredient;
use App\Models\kategori;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        $menu = Menu::select("nm_kategori", "menu.*")->join("kategori", "kategori.id", "=", "menu.kategori_id")->get();
        return view('modules.menu.index', compact('kategori', 'menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'kategori_id'   => 'required',
            'nm_menu'       => 'required',
            'price' => 'required',
        ]);

        $data = $request->all();

        Menu::create( $data );
        return redirect()->route('menu.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([

            'kategori_id'   => 'required',
            'nm_menu'       => 'required',
            'price' => 'required',
        ]);

        $data = $request->all();

        $menu = Menu::findOrFail( $id );
        $menu->update( $data );

        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::findOrFail( $id );
        $menu->delete();

        return redirect()->route('menu.index');
    }



    // ingredient
    public function ingredient( string $id ) {

        $menu = Menu::findOrFail( $id );
        $bahanbaku = Bahanbaku::all();
        $ingredient = Ingredient::select("bahanbaku.nm_bahanbaku", "ingredient.*")->join("bahanbaku", "bahanbaku.id", "=", "ingredient.bahanbaku_id")->get();
        return view('modules.menu.ingredient', compact('menu', 'bahanbaku', 'ingredient'));
    }


    public function ingredient_store( Request $request, string $id ) {

        $menu = Menu::findOrFail( $id );
        $request->validate([

            'bahanbaku_id'  => 'required',
            'jumlah'        => 'required'
        ]);

        $request['menu_id'] = $id;
        $data = $request->all();

        Ingredient::create( $data );
        return redirect('menu/ingredient/'. $id);
    }

    // udate
    public function ingredient_update( Request $request, string $id_menu, string $id ){

        $request->validate([

            'bahanbaku_id'  => 'required',
            'jumlah'        => 'required'
        ]);

        $data = $request->all();
        $ingredient = Ingredient::findOrFail( $id );

        $ingredient->update( $data );
        return redirect('menu/ingredient/'. $id_menu);
    }


    // delete
    public function ingredient_delete( string $id_menu, string $id ) {

        $ingredient = Ingredient::findOrFail( $id );
        $ingredient->delete();

        return redirect('menu/ingredient/'. $id_menu);
    }
}
