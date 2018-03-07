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
    </div>

    <div class="box">
      <div class="box-header">
        {{-- <h3 class="box-title">Data Table With Full Features</h3> --}}
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive"> 
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
            <th>Pembayaran</th>
          </tr>
          </thead>
          <tbody>
          @foreach($lhs as $lh)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $lh->id }}" /></td>
            <td><a href="{{ url('laundry/detail/'.$lh->kode) }}"> <span class="label label-primary"> {!! "&nbsp&nbsp".$lh->kode."&nbsp&nbsp" !!} </span> </a></td>
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
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
  </section>

</div>
@stop
