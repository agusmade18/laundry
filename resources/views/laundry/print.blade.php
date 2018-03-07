<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
	.brd {
	    border-collapse: collapse;
	}

	.brd, .brd td, .brd th {
	    border: 1px solid black;
	}

	.footer {
	  position: absolute;
	  right: 0;
	  bottom: 0;
	  left: 0;
	  padding: 1rem;
	  text-align: left;
	  font-size: 8px;
	}
	</style>
</head>
<body onload="window.print()" style="font-size: 10px;">
<table width="100%">
	<tr>
		<td width="50%">
			<h4>FRESH LAUNDRY</h4>
			Jl. Letda Reta No. 4 Denpasar<br>
			085739339461 <br>
			Jam Buka : 08.00 - 20.00
		</td>
		<td>
			<table width="100%">
				<tr>
					<td width="70">Kode</td>
					<td>{{ $lh->kode }}</td>
				</tr>
				<tr>
					<td>Nama</td>
					<td>{{ $lh->myCustomer->nama }}</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>{{ $lh->myCustomer->alamat }}</td>
				</tr>
				<tr>
					<td>No. Tlp</td>
					<td>{{ $lh->myCustomer->phone }}</td>
				</tr>
				<tr>
					<td>Tgl. Msk/Klr</td>
					<td>{{ date('d M Y', strtotime($lh->tgl_masuk)) }} / {{ date('d M Y', strtotime($lh->tgl_keluar)) }}</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<hr>
<table width="100%" class="brd">
	<tr>
		<td colspan="7"><strong><center>Data Barang</center></strong></td>
	</tr>
	<tr>
		<td width="10">No.</td>
		<td width="120">Nama Brg</td>
		<td width="80" align="center">Harga</td>
		<td width="40" align="center">Qty</td>
		<td width="50" align="center">Disc.</td>
		<td width="50" align="center">Jenis</td>
		<td width="80" align="center">Total</td>
	</tr>
	@foreach($lDetails as $ld)
	<tr>
		<td>{{ $i++ }}</td>
		<td>{{ $ld->barang->nama }}</td>
		<td align="center">{{ number_format($ld->harga) }}</td>
		<td align="center">{{ $ld->qty }}</td>
		<td align="center">{{ $ld->diskon_persen == '' ? '0' : $ld->diskon_persen."%" }}</td>
		<td align="center">{{ $ld->jenis }}</td>
		<td align="center">{{ number_format($ld->total) }}</td>
	</tr>
	@endforeach
</table>

<hr>

<table width="100%">
	<tr>
		<td width="50%">
			<table width="100%" style="font-weight: bold;">
				<tr>
					<td width="80">Total</td>
					<td>{{ "Rp ".number_format($lDetails->sum('total')) }}</td>
				</tr>
				<tr>
					<td>Total Brg</td>
					<td>
						@php($lDetail = App\LaundryDetail::has('barang')->where('kode', '=', $lh->kode)->get())
						@php($totQty = 0)
						@foreach($lDetail as $ld)
						  @php($totQty = $totQty + ($ld->barang->qty*$ld->qty))
						@endforeach
						{{ $totQty." Pcs" }}
					</td>
				</tr>
				<tr>
					<td>Diskon</td>
					<td>{{ $lh->diskon_persen == '' ? '0' : $lh->diskon_persen."%" }} / {{ $lh->diskon_nominal == '' ? 'Rp 0' : "Rp ".number_format($lh->diskon_nominal) }}</td>
				</tr>
				<tr>
					<td>Grand Total</td>
					<td>{{ "Rp ".number_format($lh->grand_total) }}</td>
				</tr>
				<tr>
					<td>Bayar</td>
					<td>{{ "Rp ".number_format($lh->bayar) }}</td>
				</tr>
				<tr>
					<td>
						{{ $lh->bayar >= $lh->grand_total ? 'Kembalian' : 'Kurg Byr' }}
					</td>
					<td>
						{{ $lh->bayar >= $lh->grand_total ? "Rp ".number_format($lh->bayar-$lh->grand_total) : "Rp ".number_format(($lh->bayar-$lh->grand_total)*-1) }}
					</td>
				</tr>
			</table>
		</td>
		<td>
			<table width="100%">
				<tr>
					<td width="50%" align="center">
						<center>
						Kasir<br><br><br><br><br>{{ Auth::user()->name }}</center>
					</td align="center">
					<td width="50%"><center>
						Customer<br><br><br><br><br>{{ $lh->myCustomer->nama }}</center>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div class="footer"><h5>Syarat & Ketentuan</h5>
	<ul>
		<li>Kami tidak bertanggung jawab atas pengaduan kelunturan pakaian yang sudah terjadi sebelum proses pencucian.</li>
		<li>Kami tidak bertanggung jawab atas terjadinya kelunturan pakaian jika tidak ada pemberitahuan mengenai adanya pakaian yang berpotensi luntur.</li>
		<li>Jika ada pemberitahuan mengenai adanya pakaian yang berpotensi luntur, maka pakaian tersebut wajib dimasukkan ke dalam layanan laundry satuan.</li>
		<li>Pakaian yang kelunturan oleh karena kelalaian kami akan segera diobati untuk dihilangkan kelunturannya. Jika pakaian yang kelunturan tersebut tidak mampu kami obati, maka kami akan menanggung ganti rugi atas pakaian tersebut.</li>
		<li>Biaya ganti rugi atas pengaduan kerusakan pakaian yang disebabkan oleh kelalaian kami adalah separuh dari harga beli pakaian (yang harus ditunjukkan dengan nota pembelian) dan tidak lebih dari Rp100.000. Jika pelanggan tidak dapat menunjukkan nota pembelian, maka biaya ganti rugi akan dihitung dengan cara ditaksir dari pihak kami. Pelanggan hanya diperkenankan memberikan masukan taksiran mengenai harga beli pakaian tersebut.</li>
	</ul>
</div>

</body>
</html>