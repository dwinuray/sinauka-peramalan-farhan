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
                <div class="col-md-8">
                    
                   <div class="card card-body">
                        <h4>Form Tambah Peramalan</h4>


                        <form action="{{ url('metode/ses/proses') }}" method="POST">
                            
                            @csrf

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Waktu Awal</label>
                                        <input type="month" name="awal" class="form-control" required="">
                                        <small>Pilih waktu awal</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Waktu Akhir</label>
                                        <input type="month" name="akhir" class="form-control" required="">
                                        <small>Pilih waktu akhir</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nilai Alpha</label>
                                        <input type="text" name="alpha" class="form-control" required="">
                                        <small>Parameter pemulusan alpha</small>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="form-group">
                                        <label>Pemilihan Bahan Baku</label>
                                        <select class="form-control" name="id_bahan" required="">
                                            <option value="">-- --</option>

                                            @foreach ( $bahanbaku AS $isi )
                                            <option value="{{ $isi->id }}">{{ $isi->nm_bahanbaku }}</option>
                                            @endforeach
                                        </select>
                                        <small>Pilih salah satu bahan baku</small>
                                    </div>

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Proses Peramalan</button>
                                    </div>
                                </div>
                            </div>


                        </form>
                   </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
