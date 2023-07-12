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

                <a href="{{ url('metode/ses/create') }}" class="btn btn-light-warning font-weight-bolder btn-sm">
                    Peramalan Baru
                </a>
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
                        <h4>Tabel Riwayat Peramalan</h4>


                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pembuatan</th>
                                    <th>Bahan Baku</th>
                                    <th>Awal</th>
                                    <th>Akhir</th>
                                    <th>Alpha</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ( $metode AS $index => $isi )
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ date('d M Y H.i', strtotime($isi['created_at'])) }}</td>
                                    <td>{{ $isi['nm_bahanbaku'] }}</td>
                                    <td>{{ date('F Y', strtotime($isi['awal'])) }}</td>
                                    <td>{{ date('F Y', strtotime($isi['akhir'])) }}</td>
                                    <td>{{ $isi['alpha'] }}</td>
                                    <td>
                                        <a href="{{ url('metode/ses/detail/'. $isi['id']) }}" class="btn btn-sm btn-light-primary">lihat</a>
                                        <a onclick="return confirm('Apakah anda ingin menghapus perhitungan ini ?')" href="{{ url('metode/ses/delete/'. $isi['id']) }}" class="btn btn-sm btn-light-danger">hapus</a>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
