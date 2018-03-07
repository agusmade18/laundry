@extends('layouts.index')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Penjualan
      <small>Barang</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penjualan</li>
    </ol>
  </section>
  
  <section class="content">
    <div class="row" style="padding: 1px;">
      <div class="col-md-8">
        <h3><strong>Data Penjualan</strong></h3>
      </div>
      <form action="{{ url('penjualan/search') }}" method="GET">
      <div class="col-md-3">
        <label class="control-label">Tanggal</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" name="tgl" id="reservation" value="{{ $interval }}">
        </div>
      </div>
      <div class="col-md-1">
        <div class="form-group" style="margin-top: 25px;">
          <button type="submit" class="btn btn-default" style="width: 100%;"><i class="fa fa-sort"></i>&nbsp Sort</button>
        </div>
      </div>
      </form>
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
        <form method="post" action="{{ url('aruskas/kasbesar/multipleDelete') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Kode</th>
            <th>Total</th>
            <th>jml.Item</th>
            <th>Diskon</th>
            <th>Grand Total</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($penjualan as $pj)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $pj->id }}" /></td>
            <td><a href="{{ url('penjualan/detail/'.$pj->kode) }}"> {{ $pj->kode }} </a></td>
            <td>{{ number_format($pj->total) }}</td>
            <td>@php($pd = App\PenjualanDetail::where('kode', '=', $pj->kode)->get())
              {{ $pd->sum('qty')." Item" }}</td>
            <td>{{ $pj->diskon_persen."% / ".number_format($pj->diskon_nominal) }}</td>
            <td>{{ number_format($pj->grand_total) }}</td>
            <td>{{ date('d M Y', strtotime($pj->tanggal)) }}</td>
            <td>{{ date('H:i:s', strtotime($pj->created_at)) }}</td>
            <td>
              <button type="button" class="btn btn-info"><i class="fa fa-print"></i></button>
              {{-- <button type="button" class="btn btn-success"><i class="fa fa-check"></i></button> --}}
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-8">
            {{-- <button type="button" class="btn btn-success"><i class="fa fa-check"></i>&nbsp Post Check</button>
            <button type="button" class="btn btn-success"><i class="fa fa-check-circle-o"></i>&nbsp Post All</button> --}}
            <a href="{{ url('penjualan/transaksi') }}">
            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp Add Data</button> </a>
          </div>
          <div class="col-md-4 push-right" style="font-size: 1.5em; font-weight: bold;">
            Total Penjualan : 
            Rp {{ number_format($penjualan->sum('grand_total')) }}
          </div>
        </div>
        </form>
      </div>
    </div>
  </section>
</div>
@stop