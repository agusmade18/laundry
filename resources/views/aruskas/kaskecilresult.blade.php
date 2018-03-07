@extends('layouts.index')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Arus Kas
      <small>Kas Kecil</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Arus Kas</a></li>
      <li class="active">Kas Kecil</li>
    </ol>
  </section>
  
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <h3><strong>Laporan Kas Kecil</strong></h3>
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
    
    <div class="row">
      <div class="col-md-5">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Data Global Kas Kecil</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Kode</th>
                <th>Total</th>
                <th>Tanggal</th>
              </tr>
              </thead>
              <tbody>
              @foreach($kks as $kk)
              <tr 
              @if(Request::segment(3) == $kk->kode)
              style="background-color: #cacaca;" 
              @endif
              >
                <td><a href="{{ url('aruskas/kaskecil/'.$kk->kode) }}"> {{ $kk->kode }}</a></td>
                <td>{{ number_format($kk->nominal) }}</td>
                <td>{{ date('d M Y', strtotime($kk->tanggal)) }}</td>
              </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <div class="box box-primary">
          <div class="box-header">
            <div class="row">
              <div class="col-md-6"><h3 class="box-title">Data Rincian Kas Kecil</h3></div>
              <div class="col-md-6">
                <form action="{{ url('aruskas/kaskecil/') }}" method="get">
                  <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari Data Kas Kecil" value="{{ $cari }}">
                    <span class="input-group-btn">
                          <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                          </button>
                        </span>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <table class="table table-bordered">
              <tr>
                <th>Kode</th>
                <th>Nama Pengeluaran</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Keterangan</th>
              </tr>
              @foreach($kasRs as $ks)
              <tr>
                <td>{{ $ks->kode }}</td>
                <td>{{ $ks->nama }}</td>
                <td>{{ number_format($ks->harga) }}</td>
                <td>{{ $ks->qty }}</td>
                <td>{{ number_format($ks->total) }}</td>
                <td>{{ $ks->keterangan }}</td>
              </tr>
              @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@stop
