<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index() {

    	$chart = $this->pembuatanChart();

    	$menu = DB::table("menu")->get()->count();
    	$transaksi = DB::table("transaksi")->get()->count();

        return view('modules.dashboard.dashboard', compact('chart', 'menu', 'transaksi'));
    }


    function pembuatanChart() {

    	$this_year = date('Y');
    	// $this_year = '2022';
    	
    	$start = $this_year.'-01-01';
    	$end   = $this_year.'-12-01';

    	// strtotime 
    	$start = strtotime($start);
    	$end = strtotime($end);


    	$dt_keseluruhan = array();
    	$total = 0;

    	while ( $start <= $end ) {

    		$month = (int) date('m', $start);

    		// query untuk mengkalkulasi penjualan
    		$penjualan = DB::table("transaksi_detail")->select("price", "amount")
    						->join("transaksi", "transaksi.id", "=", "transaksi_detail.transaksi_id")
    						->join("menu", "menu.id", "=", "transaksi_detail.menu_id")
    							->where(DB::raw("month(tanggal)"), $month)
    							->where(DB::raw("year(tanggal)"), $this_year)
    							->get();

    		$pendapatan = 0;
    		if ( $penjualan->count() ){

    			foreach ( $penjualan AS $isi ) {

    				$pendapatan += ( $isi->price * $isi->amount );
    			}
    		}
    		array_push( $dt_keseluruhan, [

    			'month'	=> date('M', $start),
    			'amount'=> $pendapatan
    		]);


    		$total += $pendapatan;
    		$start = strtotime("+1 month", $start);
    	}


    	return [$dt_keseluruhan, $total];
    }
}
