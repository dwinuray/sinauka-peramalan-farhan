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
                    Info Akun </h5>
                <!--end::Page Title-->

                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200">
                </div>

                <span class="text-muted font-weight-bold mr-4">Halaman Pengubahan Kata Sandi</span>
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

                    @php 

                    if ( Session::has('message') ){

                        echo Session::get('message');
                    }

                    @endphp


                    @if ( $errors->any() )

                    <div class="alert alert-danger text-left">
                        Pemberitahuan
                        <small>
                            @foreach( $errors->all() AS $isi )
                            <p>{{ $isi }}</p>
                            @endforeach
                        </small>
                    </div>

                    @endif
                        
                    <form action="{{ url('profile/update-password') }}" method="POST">

                        @csrf
                        <div class="card card-body">
                            
                            <h3>Ubah Kata Sandi</h3>

                            <div class="form-group">
                                                <label>Kata Sandi</label>
                                                <input type="password" name="password" class="form-control" placeholder=". . ." />
                                                <small>Masukkan kata sandi lama</small>
                                            </div>

                                            <div class="form-group">
                                                <label>Kata Sandi Baru</label>
                                                <input type="password" name="new_password" class="form-control" placeholder=" . . ." />
                                                <small>Masukkan kata sandi baru</small>
                                            </div>

                                            <div class="form-group">
                                                <label>Konfirmasi Kata Sandi</label>
                                                <input type="password" name="confirm_password" class="form-control" placeholder=" . . ." />
                                                <small>Masukkan kata sandi baru</small>
                                            </div>

                            <div class="form-group text-right">
                                <button class="btn btn-primary btn-sm">Simpan dan Perbarui</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection