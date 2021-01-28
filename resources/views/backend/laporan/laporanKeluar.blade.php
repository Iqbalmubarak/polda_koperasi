<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Bukti Barang Keluar</title>

</head>
<body>
<div>
		<img src="{{ asset('image/logoo.png') }}" alt="logo" height="80px" width="80px" style="float:left">
        <h2> <center>PEMERINTAH KOTA PADANG</center> </h2>
        <H2> <center> DINAS KESEHATAN</center></H2>
        <P><U> <center>Jl. Bagindo Aziz Chan By Pass Padang Telp. 0751-462619 Padang</center> </U></P>
        <h2><center><u>SURAT BUKTI BARANG KELUAR</u></center></h2>
</div>
		<?php
		$x = 0;
		?>
		@foreach($datas as $data)
		@if($x==0)
        <P>Kebutuhan untuk : {{$data->nama_satker}}</P>
		@endif
		<?php
		$x++;
		?>
		@endforeach
        <table border="2px solid" align="center" width="900px" cellpadding="8" class="col-md-12" style="border-collapse: collapse">
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Nama Barang</th>
                <th rowspan="2">Satuan</th>
				<th colspan="2">Banya Pengeluaran</th>
				<th rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th>Dengan Angka</th>
				<th>Dengan Huruf</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i = 0;
		function penyebut($nilai) {
			$nilai = abs($nilai);
			$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
			$temp = "";
			if ($nilai < 12) {
				$temp = " ". $huruf[$nilai];
			} else if ($nilai <20) {
				$temp = penyebut($nilai - 10). " belas";
			} else if ($nilai < 100) {
				$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
			} else if ($nilai < 200) {
				$temp = " seratus" . penyebut($nilai - 100);
			} else if ($nilai < 1000) {
				$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
			} else if ($nilai < 2000) {
				$temp = " seribu" . penyebut($nilai - 1000);
			} else if ($nilai < 1000000) {
				$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
			} else if ($nilai < 1000000000) {
				$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
			} else if ($nilai < 1000000000000) {
				$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
			} else if ($nilai < 1000000000000000) {
				$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
			}
			return $temp;
		}

		function terbilang($nilai) {
			if($nilai<0) {
				$hasil = "minus ". trim(penyebut($nilai));
			} else {
				$hasil = trim(penyebut($nilai));
			}
			return $hasil;
		}
		?>
		@foreach($datas as $data)
		<?php
		$i++;
		?>
			<tr>
				<td>{{$i}}</td>
				<td>{{$data->nama_barang}}</td>
				<td>{{$data->nama_satuan}}</td>
				<td style="text-align:center">{{$data->total}}</td>
				<td style="text-align:center">{{terbilang($data->total)}}</td>
                <td></td>
			</tr>
		@endforeach
		</tbody>

	</table>
	<p style="text-align:right">Padang, {{date('d F Y')}}</p> <br>

	<table align="center" cellpadding="5" width="900 " class="col-md-12" style="border-collapse: collapse;text-align:center">
                    <tr>
                        <td>Menyetujui, </td>
						<td>Yang Menyerahkan,</td>
						<td>Yang Menerima,</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
						<td></td>
                    </tr>

					<tr><td></td><td></td><td></td></tr>
					<tr><td></td><td></td><td></td></tr>
					<tr><td></td><td></td><td></td></tr>
					<tr><td></td><td></td><td></td></tr>
					<tr><td></td><td></td><td></td></tr>

					<tr>
                        <td></td>
                        <td> </td>
                        <td></td>
                    </tr>
					<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
	</table>
	<script type="text/javascript">
      window.print();
    </script>
</body>
</html>
