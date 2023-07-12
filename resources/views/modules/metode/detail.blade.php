@extends('layouts.backend')
@section('main-content')
<!--begin::Content-->
 <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
        <div
            class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">

                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                    Metode Exponential Smoothing </h5>
                <!--end::Page Title-->

                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200">
                </div>

                <span class="text-muted font-weight-bold mr-4">#Overview</span>

                <a href="{{ url('metode') }}" class="btn btn-light-default font-weight-bolder btn-sm">
                    Kembali
                </a>
                <!--end::Actions-->
            </div>
            <!--end::Info-->

          
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Dashboard-->


            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-body">
                        

                        <!-- Chart -->
                        <h3>Hasil Grafik antara Aktual dan Peramalan</h3>
                        <div id="chart_1"></div>



                        <div class="row">
                            <div class="col-md-4">
                                    
                                <h3>Parameter</h3>

                                <hr>
                                

                                <div class="form-group">
                                    <small>Nilai Pemulusan Alpha</small>
                                    <h4>{{ $parameter->alpha }}</h4>
                                </div>

                                <div class="form-group">
                                    <small>Waktu Peramalan</small>
                                    <h4>{{ date('M Y', strtotime( $parameter->awal )).' - '. date('M Y', strtotime( $parameter->akhir ))}}</h4>
                                </div>

                                <div class="form-group">
                                    <small>Bahan Baku</small>
                                    <h4>{{ $dt_bahan->nm_bahanbaku }}</h4>
                                </div>
                            </div>

                            <div class="col-md-8">
                                
                                <h3>Proses Perhitungan</h3>


                                @php 

                                    $dt_hasil_akhir = array();

                                @endphp

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aktual</th>
                                            <th>Forecast</th>
                                            <th>MAD</th>
                                            <th>MAPE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ( $perhitungan['perhitungan'] AS $index => $isi )

                                        @if ( $isi['aktual'] != "-" )
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $isi['aktual'] }}</td>
                                            <td>{{ $isi['forecast'] }}</td>
                                            <td>{{ $isi['mad'] }}</td>
                                            <td>{{ $isi['mape'] }}</td>
                                        </tr>

                                        @else

                                            @php 
                                                $dt_hasil_akhir = $isi;
                                            @endphp

                                        @endif

                                        @endforeach

                                        <tr style="font-weight: bold">
                                            <td colspan="4" class="text-right">MAPE</td>
                                            <td>{{ number_format($perhitungan['persentase'], 2) }} %</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <b>Kesimpulan : </b><br>
                                Sehingga untuk peramalan berikutnya, jumlah bahan baku yang direkomendasikan yaitu pada {{ date('F Y', $dt_hasil_akhir['waktu']) }} berjumlah {{ $dt_hasil_akhir['forecast'] }}
                            </div>
                        </div>



                    </div>
                </div>
            </div>


        </div>
    </div>
</div>




 <script>

            <?php

                $actual = $perhitungan['x'];
                $forecast = $perhitungan['y'];
                $time = $perhitungan['time'];

            ?>

            $(function() {

                // Shared Colors Definition
                const primary = '#6993FF';
                const success = '#1BC5BD';
                const info = '#8950FC';
                const warning = '#FFA800';
                const danger = '#F64E60';


                $('#kt_quick_user_toggle').click(function() {

                    $('#form-logout').submit();
                });


                const apexChart = "#chart_1";
                var options = {
                    series: [
                        {
                            name: "Aktual",
                            data: [{{ implode(', ', $actual) }}]
                        },
                        {
                            name: "Peramalan",
                            data: [{{ implode(', ', $forecast) }}]
                        },
                    ],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {   
                        enabled: false
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: [

                            <?php

                                foreach ( $time AS $isi ) {


                                    echo '"'.$isi.'",';
                                }
                            ?>
                        ],
                    },
                    colors: [info, success]
                };

                var chart = new ApexCharts(document.querySelector(apexChart), options);
                chart.render();
            });
        </script>
@endsection