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
      <div class="col-md-6">
        <h3><strong>Total Uang : Rp {{ number_format($lhs->sum('grand_total')) }}</strong></h3>
      </div>
      <div class="col-md-6">
        <div class="row" style="margin-top: 15px; margin-bottom: 5px;">
          <div class="col-md-3 pull-right" style="padding-left: 1px;padding-top: 1px;padding-bottom: 1px;">
            <button type="button" class="btn btn-block btn-info btn-lg"><i class="fa fa-list"></i></button>
          </div>
        </div>
      </div>
    </div>

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

    <div class="box">
      <div class="box-header">
        {{-- <h3 class="box-title">Data Table With Full Features</h3> --}}
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <form method="post" action="{{ url('laundry/multipleDelete') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Kode</th>
            <th>Data Customer</th>
            <th>Tgl Masuk</th>
            <th>Tgl Keluar</th>
            <th>Total</th>
            <th>Qty Brg</th>
            <th width="100">Pembayaran</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($lhs as $lh)
          <tr>
            <td><input type="checkbox" name="kode[]" value="{{ $lh->kode }}" /></td>
            <td><a href="{{ url('laundry/detail-delete/'.$lh->kode) }}"> <span class="label label-primary"> {!! "&nbsp&nbsp".$lh->kode."&nbsp&nbsp" !!} </span> </a></td>
            <td>{{ $lh->myCustomer->nama }} ( 
                {{ $lh->myCustomer->phone }} ) /  
                {{ $lh->myCustomer->alamat }} <a href="{{ url('laundry/cetak/'.$lh->kode) }}"><button class="btn btn-info pull-right"><i class="fa fa-print"></i></button></a></td>
            <td>{{ date('d M Y', strtotime($lh->tgl_masuk)) }}</td>
            <td>{{ date('d M Y', strtotime($lh->tgl_keluar)) }}</td>
            <td>{{ number_format($lh->grand_total) }}</td>
            <td>
              @php($lDetail = App\LaundryDetail::has('barang')->where('kode', '=', $lh->kode)->get())
              @php($totQty = 0)
              @foreach($lDetail as $ld)
                @php($totQty = $totQty + ($ld->barang->qty*$ld->qty))
              @endforeach
              {{ $totQty." Pcs" }}
            <td>
              @if($lh->bayar >= $lh->grand_total)
              <span class="label label-success">Lunas</span>
              @elseif($lh->bayar <= 0)
              <span class="label label-danger">Belum Lunas</span>
              @endif
            </td>
            <td class="center">
              <a href="{{ url('laundry/hapusPermanen/'.$lh->kode) }}">
              <button class="btn btn-danger" type="button" onclick="return confirm('Hapus Data ini secara Permanen?')"><i class="fa fa-remove"></i></button></a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-1">
            <button type="submit" name="batalAll" value="batalAll" class="btn btn-danger"><i class="fa fa-remove" onclick="return confirm('Hapus Permanen Semua Transaksi ini?')">&nbsp Hapus Selamanya</i></button>
          </div>
        </div>
        </form>
      </div>
      <!-- /.box-body -->
    </div>
  </section>

</div>
@stop
