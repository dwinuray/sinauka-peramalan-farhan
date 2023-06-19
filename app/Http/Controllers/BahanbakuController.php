<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bahanbaku;

class BahanbakuController extends Controller
{
    public function index() {

    	$bahan = Bahanbaku::all();

    	return view('modules.bahanbaku.index', compact('bahan'));
    }


    public function store( Request $request ) {

    	$request->validate([

    		'nm_bahanbaku'	=> 'required|string'
    	]);


    	$data = $request->all();
    	Bahanbaku::create( $data );


    	$pesan = '<div class="alert alert-success">Pemberitahuan<br><small>Proses tambah bahan baku berhasil</small></div>';
    	session()->flash('message', $pesan);

    	return redirect()->route('bahanbaku.index');
    }


    public function update( Request $request, $id ) {


    	$request->validate([

    		'nm_bahanbaku'	=> 'required|string'
    	]);


    	$data = $request->all();
    	$bahanbaku = Bahanbaku::findOrFail( $id );
    	$bahanbaku->update( $data );


    	$pesan = '<div class="alert alert-success">Pemberitahuan<br><small>Proses pengubahan bahan baku berhasil</small></div>';
    	session()->flash('message', $pesan);

    	return redirect()->route('bahanbaku.index');
    }


    public function destroy( Request $request, $id ) {

    	$bahanbaku = Bahanbaku::findOrFail( $id );
    	$bahanbaku->delete();

    	$pesan = '<div class="alert alert-success">Pemberitahuan<br><small>Proses hapus bahan baku berhasil</small></div>';
    	session()->flash('message', $pesan);

    	return redirect()->route('bahanbaku.index');
    }
}
