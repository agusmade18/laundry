@extends('layouts.index')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Laporan
      <small>Harian</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content"> 
    <div class="row">

      @if(Session::has('message'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
        {{ Session::get('message') }}
      </div>
      @endif

      @if(Session::has('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Error!</h4>
        {{ Session::get('error') }}
      </div>
      @endif

      <section class="col-lg-12 connectedSortable">
        <div class="box box-primary">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6">
                <h4><strong>Data Laporan : {{ date('d M Y', strtotime($tanggal)) }}</strong></h4>
              </div>
            </div>
          </div>
          <div class="box-body chat" id="chat-box">
            <div class="box-body">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Laundry Masuk</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th>Kode</th>
                      <th>Data Customer</th>
                      <th>Tgl Masuk</th>
                      <th>Tgl Keluar</th>
                      <th>Total</th>
                      <th>Qty Brg</th>
                      <th>Pembayaran</th>
                    </tr>
                    @foreach($laundryMasuk as $lMasuk)
                    <tr>
                      <td>{{ $lMasuk->kode }}</td>
                      <td>{{ $lMasuk->myCustomer->nama }}</td>
                      <td>{{ date('d M Y', strtotime($lMasuk->tgl_masuk)) }}</td>
                      <td>{{ date('d M Y', strtotime($lMasuk->tgl_keluar)) }}</td>
                      <td>{{ number_format($lMasuk->grand_total) }}</td>
                      <td>
                        @php($lDetail = App\LaundryDetail::has('barang')->where('kode', '=', $lMasuk->kode)->get())
                        @php($totQty = 0)
                        @foreach($lDetail as $ld)
                          @php($totQty = $totQty + ($ld->barang->qty*$ld->qty))
                        @endforeach
                        {{ $totQty." Pcs" }}
                      <td>
                        @if($lMasuk->bayar >= $lMasuk->grand_total)
                        <span class="label label-success">Lunas</span>
                        @elseif($lMasuk->bayar <= 0)
                        <span class="label label-danger">Belum Lunas</span>
                        @elseif($lMasuk->bayar < $lMasuk->grand_total)
                        <span class="label label-warning">Stgh Byr</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </table>
                </div>
              </div>

              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Laundry Keluar</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th>Kode</th>
                      <th>Data Customer</th>
                      <th>Tgl Masuk</th>
                      <th>Tgl Keluar</th>
                      <th>Total</th>
                      <th>Qty Brg</th>
                      <th>Pembayaran</th>
                    </tr>
                    @foreach($laundryKeluar as $lKeluar)
                    <tr>
                      <td>{{ $lKeluar->kode }}</td>
                      <td>{{ $lKeluar->myCustomer->nama }}</td>
                      <td>{{ date('d M Y', strtotime($lKeluar->tgl_masuk)) }}</td>
                      <td>{{ date('d M Y', strtotime($lKeluar->tgl_keluar)) }}</td>
                      <td>{{ number_format($lKeluar->grand_total) }}</td>
                      <td>
                        @php($lDetail = App\LaundryDetail::has('barang')->where('kode', '=', $lKeluar->kode)->get())
                        @php($totQty = 0)
                        @foreach($lDetail as $ld)
                          @php($totQty = $totQty + ($ld->barang->qty*$ld->qty))
                        @endforeach
                        {{ $totQty." Pcs" }}
                      <td>
                        @if($lKeluar->bayar >= $lKeluar->grand_total)
                        <span class="label label-success">Lunas</span>
                        @elseif($lKeluar->bayar <= 0)
                        <span class="label label-danger">Belum Lunas</span>
                        @elseif($lKeluar->bayar < $lKeluar->grand_total)
                        <span class="label label-warning">Stgh Byr</span>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">

          </div>
        </div>
      </section>
    </div>

  </section>
</div>
@stop