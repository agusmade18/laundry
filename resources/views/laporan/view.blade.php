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
                <h4><strong>Data Laporan {{ date('d M Y', strtotime($myFDate)) }} - {{ date('d M Y', strtotime($myLDate)) }}</strong></h4>
              </div>
              <div class="col-md-6">
                <form action="{{ url('laporan/harian-search') }}" method="get">
                  <div class="col-md-9">
                    <label class="control-label">Tanggal</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" name="tgl" id="reservation" value="{{ $interval }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group" style="margin-top: 25px;">
                      <button type="submit" class="btn btn-default" style="width: 100%;"><i class="fa fa-sort"></i> Sort</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="box-body chat" id="chat-box">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Laundry</th>
                  <th>Penjualan</th>
                  <th>Fisik Uang</th>
                  <th>Laba Penjualan</th>
                  <th>Keterangan</th>
                </tr>
                </thead>
                <tbody>
                @foreach($lapHarians as $lh)
                <tr>
                  <td>{{ date('d M Y', strtotime($lh->tanggal)) }}</td>
                  <td>{{ $lh->jum_laundry }} Transaksi <br> {{ number_format($lh->total_laundry) }}</td>
                  <td>{{ $lh->jum_penjualan }} Transaksi <br> {{ number_format($lh->tot_penjualan) }}</td>
                  <td>{{ number_format($lh->fisik_uang) }}</td>
                  <td>{{ number_format($lh->laba_penjualan) }}</td>
                  <td>{{ $lh->keterangan }}</td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="box-footer">
            <a href="{{ url('laporan/harian-add') }}">
            <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Closing Harian</button> </a>
          </div>
        </div>
      </section>
    </div>

  </section>
</div>
@stop