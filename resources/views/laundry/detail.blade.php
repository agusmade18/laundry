@extends('layouts.index')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-3 connectedSortable">
        <div class="box box-success">
          <div class="box-header">
            Data Customer
          </div>
          <div class="box-body">
            <table class="table table-bordered">
              <tr>
                <td width="100">Kode</td>
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
                <td>No. Telp.</td>
                <td>{{ $lh->myCustomer->phone }}</td>
              </tr>
              <tr>
                <td>Tgl. Masuk</td>
                <td>{{ date('d M Y', strtotime($lh->tgl_masuk)) }}</td>
              </tr>
              <tr>
                <td>Tgl. Keluar</td>
                <td>{{ date('d M Y', strtotime($lh->tgl_keluar)) }}</td>
              </tr>
              <tr>
                <td>Ketr. Khusus</td>
                <td>{{ $lh->keterangan }}</td>
              </tr>
              <tr>
                <td>Kasir</td>
                <td>{{ $lh->usr->name }}</td>
              </tr>
              <tr>
                <td>Status</td>
                <td>
                  @if($lh->bayar >= $lh->grand_total)
                  <span class="label label-success">Lunas</span>
                  @elseif($lh->bayar <= 0)
                  <span class="label label-danger">Belum Lunas</span>
                  @endif
                </td>
              </tr>
            </table>
          </div>
          <div class="box-footer">
            <div class="box-footer">
              
            </div>
          </div>
        </div>
      </section>

      <section class="col-lg-9 connectedSortable">
        <div class="box box-primary">
          <div class="box-header">
            Data Transaksi
          </div>
          <div class="box-body">
            <table class="table">
              <tr>
                <td>Nama</td>
                <td>Jenis</td>
                <td>Qty</td>
                <td>Harga</td>
                <td>Hanger</td>
                <td>Express</td>
                <td>Diskon</td>
                <td>Total</td>
              </tr>
              @foreach($lDetails as $ld)
              <tr>
                <td>{{ $ld->barang->nama }}</td>
                <td>{{ $ld->jenis }}</td>
                <td>{{ $ld->qty }}</td>
                <td>{{ number_format($ld->harga) }}</td>
                <td>{{ number_format($ld->hanger) }}</td>
                <td>{{ number_format($ld->express) }}</td>
                <td>{!! $ld->diskon_persen."%<br>Rp ".number_format($ld->diskon_nominal) !!}</td>
                <td>{{ number_format($ld->total) }}</td>
              </tr>
              @endforeach
            </table>
          </div>
          <div class="box-footer">
            <div class="box-footer">
              <div style="padding-left: 10px; font-size: 1.3em; font-weight: bold;">
                <div class="row">
                  <div class="col-md-3">Total</div>
                  <div class="col-md-9">{{ "Rp ".number_format($lh->total) }}</div>
                </div>
                <div class="row">
                  <div class="col-md-3">Diskon </div>
                  <div class="col-md-9">{{ $lh->diskon_persen == '' ? '0' : $lh->diskon_persen."%" }} / {{ $lh->diskon_nominal == '' ? 'Rp 0' : "Rp ".number_format($lh->diskon_nominal) }}</div>
                </div>
                <div class="row">
                  <div class="col-md-3">Grand Total</div>
                  <div class="col-md-9">{{ "Rp ".number_format($lh->grand_total) }}</div>
                </div>
                <div class="row">
                  <div class="col-md-3">Bayar</div>
                  <div class="col-md-9">{{ "Rp ".number_format($lh->bayar) }}</div>
                </div>
                <div class="row">
                  <div class="col-md-3">{{ $lh->bayar >= $lh->grand_total ? 'Kembalian' : 'Kurg Byr' }}</div>
                  <div class="col-md-3">{{ $lh->bayar >= $lh->grand_total ? "Rp ".number_format($lh->bayar-$lh->grand_total) : "Rp ".number_format(($lh->bayar-$lh->grand_total)*-1) }}</div>
                  
                  
                  @if(Request::segment(2) != "detail-delete")
                  <div class="col-md-2 pull-right" style="padding-left: 1px;">
                    <a onclick="return confirm('Batalkan Transaksi Ini?');" href="{{ url('laundry/batal/'.$lh->kode) }}">
                      <button type="button" class="btn btn-danger" style="width: 100%; margin-bottom: 5px;"><i class="icon-remove"></i> Hapus</button>
                    </a>
                  </div>
                  @endif
                  <div class="col-md-2 pull-right" style="padding-left: 1px;padding-right: 1px;">
                    <a href="{{ url('laundry/print/'.$lh->kode) }}">
                      <button type="button" class="btn btn-info" style="width: 100%; margin-bottom: 5px;"><i class="icon-print"></i> Cetak</button>
                    </a>
                  </div>
                  <div class="col-md-2 pull-right" style="padding-right: 1px;">
                    <a href="{{ url('laundry/view') }}">
                      <button type="button" class="btn btn-warning" style="width: 100%; margin-bottom: 5px;"><i class="icon-chevron-left"></i> Kembali</button>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>

</div>

@stop