<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB, Hash;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pegawai = DB::table("users")->where("role", "admin")->get();
        return view('modules.pegawai.index', compact('pegawai'));
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

            'email' => 'required|email|unique:users,email',
            'name'      => 'required',
            'password'  => 'required|min:6'
        ]);

        $post = $request->all();
        $post['password'] = Hash::make( $request->password );


        array_shift($post);
        $post['role'] = "admin";
        
        DB::table("users")->insert( $post );
        return redirect()->route('pegawai.index');
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

            'email' => 'required|email',
            'name'      => 'required',
        ]);

        $post = $request->all();

        array_shift($post);
        $post['role'] = "admin";
        
        DB::table("users")->insert( $post );
        return redirect()->route('pegawai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
