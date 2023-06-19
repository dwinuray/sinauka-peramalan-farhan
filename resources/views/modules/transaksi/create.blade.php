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
                    Master Transaksi </h5>
                <!--end::Page Title-->

                <!--begin::Actions-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200">
                </div>

                <span class="text-muted font-weight-bold mr-4">Halaman Master Transaksi - Tambah Laporan</span>
                <!--end::Actions-->
            </div>
            <!--end::Info-->

          
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Dashboard-->


            <div class="row">
                <div class="col-md-12">
                    

                    <form action="" method="GET">
                    <div class="card card-body">


                        @php 


                        $tanggal = date('Y-m-d');
                        $notes = "";
                        $amount = "";


                        if ( !empty( $request->date ) ) {

                            $tanggal =date('Y-m-d', strtotime( $request->date ));
                            $notes = $request->notes;
                            $amount = $request->amount;
                        }
                    

                        @endphp
                        
                        <!-- Info -->
                        <div class="row">
                            <div class="col-md-3">
                                <p style="margin: 0px">Penanggung Jawab</p>
                                <h2 style="margin: 0px">{{ Auth::user()->name }}</h2>
                            </div>

                            <div class="col-md-3">
                                <p style="margin: 0px">Tanggal Transaksi</p>
                                <input type="date" name="date" class="form-control" value="{{ $tanggal }}">
                            </div>

                            <div class="col-md-4">
                                <p style="margin: 0px">Catatan</p>
                                <input type="text" class="form-control" name="notes" placeholder="Masukkan catatan apabila diperlukan" value="{{ $notes }}" />
                            </div>
                            <div class="col-md-1">
                                <p style="margin: 0px">Jumlah</p>
                                <input type="number" class="form-control" name="amount" value="{{ $amount }}" min="1" max="{{ $menu->count() }}" placeholder="..." required="" />
                            </div>
                            <div class="col-md-1">
                                <button style="margin-top: 22px" class="btn btn-sm btn-primary">+</button>
                            </div>
                        </div>

                    </div>
                    </form>
                </div>
            </div>


            <!-- Isi -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card card-body">


                        <form action="{{ route('transaksi.store') }}" method="POST">

                            @csrf

                            <input type="hidden" name="tanggal" value="{{ $request->date }}">
                            <input type="hidden" name="notes" value="{{ $request->notes }}">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pilih Item</th>
                                        <th>Jumlah Pesanan</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if ( !empty($request->amount) )

                                    @for ( $i = 0; $i < $request->amount; $i++ )

                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" name="ids[]" required="">
                                                    <option value="">-- Pilih menu pesanan --</option>
                                                    @foreach ( $menu AS $isi )
                                                    <option value="{{ $isi->id }}">{{ $isi->kategori->nm_kategori.' | '.$isi->nm_menu }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" name="q[]" class="form-control" placeholder=" . . ." required="">
                                            </div>
                                        </td>
                                        <td>
                                            @php 
                                            $query = url('transaksi/create?date='.$tanggal.'&notes='. $notes.'&amount='. $amount - 1);
                                            @endphp

                                            <a href="{{ $query }}" class="btn btn-secondary">Batalkan</a>
                                        </td>
                                    </tr>

                                    @endfor
                                    @endif

                                    
                                </tbody>
                            </table>


                            @if ( !empty( $request->amount ) && $request->amount != 0 )
                            <div class="text-right">
                                <a href="{{ route('transaksi.create') }}" class="btn btn-warning">Reset Form</a>
                                <button class="btn btn-primary">Tambahkan dan Simpan</button>
                            </div>
                            @endif
                        </form>

                    </div>
                </div>
            </div>

            <!--end::Dashboard-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

@endsection