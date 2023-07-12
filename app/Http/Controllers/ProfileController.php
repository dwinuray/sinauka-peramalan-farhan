<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    
        return view('modules.profile.menu-profile');
    }


    public function view_update_info() {

        return view('modules.profile.change-info');
    }

    public function view_update_pw() {

        return view('modules.profile.change-password');
    }


    // update info 
    public function update_info( Request $request ){

        $request->validate([

            'email' => 'required',
            'name'  => 'required'
        ]);


        $id = Auth::user()->id;

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();


        $html = '<div class="alert alert-success">Pemberitahuan<br><small>Profile berhasil diperbarui pada '.date('d F Y').'</small></div>';
        session()->flash('message', $html);
        return redirect()->route('profile.index');
    }



    // update password
    public function update_password( Request $request ) {

        $request->validate([

            'password'          => 'required',
            'new_password'      => 'required',
            'confirm_password'  => 'required|same:new_password'
        ]);

        $id = Auth::user()->id;
        $user = User::findOrFail($id);


        if ( Hash::check($request->password, $user->password) ) {

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('profile.index');
        } else {

            $html = '<div class="alert alert-success">Pemberitahuan<br><small>Kata sandi lama anda tidak valid, harap periksa kembali '.date('d F Y').'</small></div>';
            session()->flash('message', $html);

            return redirect()->back();

        }

        

        
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
