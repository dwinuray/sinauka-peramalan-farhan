<!DOCTYPE html>
<html>
<head>
	<title></title>
	
</head>
<body>

	<div style="text-align: center; margin-bottom: 32px">
        <h3 style="margin:0px">LAPORAN TRANSAKSI VOSCO COFFE</h3>
        <h4 style="margin:0px">{{ $keterangan }}</h4>
    </div>


     <table style="border-collapse: collapse; width: 100%" border="1">
        <tr>
            <th rowspan="2" style="padding: 5px">No</th>
            <th rowspan="2">Tanggal</th>
            <th rowspan="2">Pembuat</th>
            <th rowspan="2">Notes</th>
            <th colspan="4">Rincian</th>
        </tr>
        <tr>
            <th style="padding: 4px">Nama</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>

        @php 

            $subtotal_keseluruhan = 0;
        @endphp

        @foreach ( $dt_keseluruhan AS $index => $isi )

        @php 

            $count_item = count( $isi->detail );
            $first = $isi->detail[0];
            $first_subtotal = $first->permintaan * $first->price;

            $need_rowspan = $count_item;          

            $subtotal_keseluruhan += $first_subtotal;

        @endphp
        <tr>
            <td rowspan="{{ $need_rowspan }}" style="text-align: center;">{{ $index + 1 }}</td>
            <td rowspan="{{ $need_rowspan }}" style="text-align: center;">{{ date('d M Y', strtotime($isi->tanggal)) }}</td>
            <td rowspan="{{ $need_rowspan }}">{{ $isi->name }}</td>
            <td rowspan="{{ $need_rowspan }}">{{ $isi->notes }}</td>
            <td style="padding: 4px">{{ $first->nm_menu }}</td>
            <td>{{ $first->permintaan }}</td>
            <td style="text-align: right;">{{ number_format($first->price) }}</td>
            <td style="text-align: right;">{{ number_format($first_subtotal) }}</td>
        </tr>
        @if ( $count_item > 1 )

        @foreach ( $isi->detail AS $index => $isi_det )

        @php 
            if ( $index == 0 ) {

                continue;
            } else {

                $subtotal_keseluruhan += ($isi_det->permintaan * $isi_det->price);
            }
        @endphp
        <tr>
            <td style="padding: 4px">{{ $isi_det->nm_menu }}</td>
            <td>{{ $isi_det->permintaan }}</td>
            <td style="text-align: right;">{{ number_format($isi_det->price) }}</td>
            <td style="text-align: right;">{{ number_format($isi_det->permintaan * $isi_det->price) }}</td>
        </tr>
        @endforeach
        @endif
        @endforeach

        <tr>
            <td colspan="7" style="text-align: right"><b>Total</b></td>
            <td style="text-align: right;">Rp {{ number_format( $subtotal_keseluruhan ) }}</td>
        </tr>

    </table>

</body>
</html>