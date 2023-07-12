<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetodeController extends Controller
{
    //

    public function index(){

    	$metode = $this->tampil_data_peramalan();
    	return view('modules.metode.index', compact('metode'));
    }



    // pengolahan untuk menampilkan di tabel 
    function tampil_data_peramalan() {

    	$metode = DB::table("metode")->get();

    	$dt_keseluruhan = array();
    	if ( $metode->count() > 0 ) {

    		foreach ( $metode AS $isi )  {

    			// decoding 
    			$decode_parameter = json_decode($isi->parameter);

    			$dt_bahan = DB::table("bahanbaku")->where("id", $decode_parameter->id_bahan)->first();
    			$alpha = $decode_parameter->alpha;
    			$awal = $decode_parameter->awal;
    			$akhir = $decode_parameter->akhir;


    			array_push ( $dt_keseluruhan,  [

    				'id'	=> $isi->id,
    				'nm_bahanbaku'  => $dt_bahan->nm_bahanbaku,
    				'alpha'		=> $alpha,
    				'awal'		=> $awal,
    				'akhir'		=> $akhir,
    				'created_at'=> $isi->created_at
    			]);
    		}
    	}

    	return $dt_keseluruhan;
    }










    // tampil data detail
    public function detail( $id ){


    	// ambil informasi detail metode berdasarkan id 
    	$metode = DB::table("metode")->where("id", $id)->first();

    	$decode_perhitungan = json_decode($metode->data_perhitungan);
    	$parameter = json_decode($metode->parameter);
    	$perhitungan = $this->olahmetode( $decode_perhitungan );


    	$dt_bahan = DB::table("bahanbaku")->where("id", $parameter->id_bahan)->first();


    	return view('modules.metode.detail', compact('perhitungan', 'parameter', 'dt_bahan'));
    }


    // olah metode
    function olahmetode( $perhitungan ) {

    	// total 
    	$total_mape = 0;

    	$dt_perhitungan = array();
    	$x = [];
    	$y = [];
    	$time = [];

    	foreach ( $perhitungan AS $isi ) {


    		$mad = 0;
    		$mape = 0;
    		if ( $isi->aktual != "-" ) {

    			$mad = abs( $isi->aktual - $isi->forecast );
    			$mape = ($mad / (float) $isi->aktual * 100);

    			array_push( $x, $isi->aktual );
	    		array_push( $y, $isi->forecast );
	    		array_push( $time, date('M Y', $isi->waktu) );
    		}

    		

    		array_push( $dt_perhitungan, [

    			'waktu'		=> $isi->waktu,
    			'aktual'	=> $isi->aktual,
    			'forecast'	=> $isi->forecast,
    			'mad'		=> $mad,
    			'mape'		=> $mape
    		]);

    		$total_mape += $mape;
    	}


    	// avg 
    	$persentase = 0;
    	if ( $total_mape != 0 ) {

    		$n = count( $perhitungan ) - 1;
    		$persentase = $total_mape / $n;
    	}
    	return [

    		'persentase'	=> $persentase,
    		'perhitungan'	=> $dt_perhitungan,
    		'x'	=> $x,
    		'y'	=> $y,
    		'time'	=> $time
    	];

    }










    public function view_tambah() {

    	$bahanbaku = DB::table("bahanbaku")->get();

    	return view('modules.metode.create', compact('bahanbaku'));
    }


    public function proses( Request $request ) {


    	// $awal = "2022-01";
    	// $akhir = "2022-11";
    	// $alpha = 0.1;
    	// $id_bahan = 4;


    	$awal = $request->awal;
    	$akhir = $request->akhir;
    	$alpha = $request->alpha;
    	$id_bahan = $request->id_bahan;

    	// @TODO 1 : Persiapan dataset
    	$dataset = $this->dataset( $awal, $akhir, $id_bahan);


    	if ( count( $dataset ) > 0 ) {


    		// parameter
    		$dt_parameter = array(

    			'awal'		=> $awal,
    			'akhir'		=> $akhir,
    			'alpha'		=> $alpha,
    			'id_bahan'	=> $id_bahan
    		);

    		// eksekusi peramalan
    		$hasil = $this->peramalan( $dataset, $alpha );


    		// encoding
    		$hasil_encode = json_encode($hasil);
    		$parameter_encode = json_encode($dt_parameter);


    		// eksekusi insert ke database
    		$data = array(

    			'data_perhitungan'	=> $hasil_encode,
    			'parameter'			=> $parameter_encode
    		);


    		// insert to database
    		DB::table("metode")->insert( $data );

    		// return redirect
    		return redirect('metode');

    	} else {

    		echo "Pada tanggal yang anda pilih, tidak memiliki dataset yang tersedia";
    	}

    }


    function dataset( $awal, $akhir, $id_bahan ) {

    	// ambil data penjualan
    	$awal = strtotime( $awal.'-01' );
    	$akhir = strtotime( $akhir.'-01' );

    	$dt_dataset = array();

    	while ( $awal <= $akhir ) {


    		// echo date('F Y', $awal).'<br>';


    		$month = (int) date('m', $awal);
    		$year = (int) date('Y', $awal);

    		$detail = DB::table("transaksi_detail")->select("menu_id", "amount")
    					->join("transaksi", "transaksi.id", "=", "transaksi_detail.transaksi_id")
    					->where(DB::raw('MONTH(tanggal)'), $month)
    					->where(DB::raw('YEAR(tanggal)'), $year)->get();


    		$total_kebutuhan = 0;

    		// cek apakah pada bulan dan tanggal tersebut memiliki transaksi ?
    		if ( $detail->count() > 0 ) {

    			// ambil data keseluruhan transaksi
    			foreach ( $detail AS $isi )	{

    				// cek apakah memiliki ingredient sesuai id_bahan baku ? 
    				$ingredient = DB::table("ingredient")
    									->where("menu_id", $isi->menu_id)
    									->where("bahanbaku_id", $id_bahan)
    									->get();

    				if ( $ingredient->count() == 0 ) {

    					continue;

    				}

    				// jika status memiliki bahan baku ingredient 
    				$kebutuhan = $ingredient[0]->jumlah;
    				$pesanan = $isi->amount;

    				// increment ke total kebutuhan
    				$total_kebutuhan += ( $kebutuhan * $pesanan );

    				// echo "<hr>";
    			}
    		}



    		array_push( $dt_dataset, [

    			'aktual'	=> $total_kebutuhan,
    			'waktu'		=> $awal
    		] );


    		$awal = strtotime("+1 month", $awal);
    	}

    	return $dt_dataset;
    }



    // peramalan
    function peramalan( $dataset, $alpha ) {

    	$dt_hasil = array();

    	foreach ( $dataset AS $index => $ds ) {

    		// apabila peramalan terjadi di urutan 1 atau pertama maka nilai aktual = forecast
    		if ( $index == 0 ) {

    			$hitung = $ds['aktual'];
    			// echo date('M Y', $ds['waktu']).' = '. $ds['aktual'];

    		} else {


    			// peramalan bulan selanjutnya 
    			$sebelumnya = $dt_hasil[$index - 1];

    			// print_r( $sebelumnya );
    			$X = $sebelumnya['aktual'];
    			$Ft_1 = $sebelumnya['forecast'];

    			$hitung = ( $alpha * $X ) + (( 1 - $alpha ) * $Ft_1 );

    			// echo date('M Y', $ds['waktu']).' = '. $hitung;
    		}

    		// echo "<hr>";
    		array_push( $dt_hasil, [

    			'waktu'		=> $ds['waktu'],
    			'aktual'	=> $ds['aktual'],
    			'forecast'	=> $hitung
    		]);
    	}


    	// hasil pada selanjutnya
    	$index_prediksi = count($dataset) - 1;
    	$sebelumnya = $dt_hasil[$index_prediksi];

    	$ds = $dataset[$index_prediksi];

    	// print_r( $index );
    	$X = $sebelumnya['aktual'];
    	$Ft_1 = $sebelumnya['forecast'];

    	$hitung = ( $alpha * $X ) + (( 1 - $alpha ) * $Ft_1 );
    	$hasil_prediksi = array(

    		'waktu'		=> strtotime("+1 month", $ds['waktu']),
    		'aktual'	=> "-",
    		'forecast'	=> $hitung
    	);


    	// combine between dt_hasil and hasil_prediksi
    	array_push( $dt_hasil, $hasil_prediksi );


    	return $dt_hasil;
    }





    public function delete( $id ) {

    	DB::table("metode")->where("id", $id)->delete();
    	return redirect('metode');
    }
}
