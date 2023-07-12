<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Transaksi;

use DB, Auth, PDF;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $dt_transaksi = array();

        $transaksi = Transaksi::all();

        if ( $transaksi->count() > 0 ) {

            foreach ( $transaksi AS $isi ) {

                // ambil data informasi transasi detail 
                $transaksi_detail = DB::table("transaksi_detail")->select("transaksi_detail.amount", "menu.*")
                                                                ->join("menu", "menu.id", "=", "transaksi_detail.menu_id")
                                                                ->where("transaksi_id", $isi->id)->get();


                $isi->transaksi_detail = $transaksi_detail;
                array_push ( $dt_transaksi, $isi );
            }
        }


        return view('modules.transaksi.index', compact('dt_transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request )
    {
        $menu = Menu::all();
        return view('modules.transaksi.create', compact('request', 'menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tanggal = $request->tanggal;
        $notes = $request->notes;

        $data = array(

            'user_id'   => Auth::user()->id,
            'tanggal'   => $tanggal,
            'notes'     => $notes
        );

        // data transaksi
        $transaksi_id = Transaksi::create( $data )->id;


        $menu_ids = $request->ids;
        $qty = $request->q;

        $transaksi_detail = array();
        foreach ( $menu_ids AS $index => $id ) {

            array_push( $transaksi_detail, [

                'transaksi_id'  => $transaksi_id,
                'menu_id'       => $id,
                'amount'        => $qty[$index]
            ]);
        }


        DB::table("transaksi_detail")->insert( $transaksi_detail );

        $message = '<div class="alert alert-success">Pemberitahuan<br><small>Penambahan transaksi berhasil</small></div>';
        session()->flash( 'message', $message );

        return redirect()->route('transaksi.index');
    }



    // cetak dengan pdf 
    public function cetak_laporan( Request $request ){

        // input
        $awal = strtotime( $request->start );
        $akhir = strtotime( $request->end );

        $dt_keseluruhan = array();


        // transaksi 
        $dt_transaksi = DB::table("transaksi")->select("transaksi.*", "users.name")
                            ->join("users", "users.id", "=", "transaksi.user_id")
                            ->get();


        $keterangan = "";


        foreach ( $dt_transaksi AS $isi ) {


            $id = $isi->id;
            $dt_detail = DB::table("transaksi_detail")->select("transaksi_detail.amount AS permintaan", "menu.*")
                        ->join("menu", "menu.id", "=", "transaksi_detail.menu_id")
                        ->where("transaksi_id", $id)
                        ->get();   

            $isi->detail = $dt_detail;


            $tanggal = strtotime( $isi->tanggal );


            if ( $awal == $akhir && $awal == $tanggal ) {

                array_push( $dt_keseluruhan, $isi );
                $keterangan = "Rekapitulasi berdasarkan tanggal ". date('d M Y', $awal);

            } else if ( $awal <= $tanggal && $tanggal <= $akhir ) {

                array_push( $dt_keseluruhan, $isi );
                $keterangan = "Rekapitulasi berdasarkan tanggal ". date('d M Y', $awal).' sampai '. date('d M Y', $akhir);
            }
        }

        

        $pdf = PDF::loadview('modules.transaksi.cetak', compact('dt_keseluruhan', 'keterangan'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan-transaksi.pdf');
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
        $transaksi = Transaksi::findOrFail( $id );

        DB::table('transaksi_detail')->where('transaksi_id', $id)->delete();
        $transaksi->delete();

        $message = '<div class="alert alert-success">Pemberitahuan<br><small>Hapus transaksi berhasil</small></div>';
        session()->flash( 'message', $message );

        return redirect()->route('transaksi.index');

        // echo "Oke";
    }
}
