@extends('layouts.index')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Restok
      <small>Barang</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Restok</li>
    </ol>
  </section>
  
  <section class="content">
    <div class="row" style="padding: 1px;">
      <div class="col-md-8">
        <h3><strong>Data Restok Barang</strong></h3>
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
            <th>Keterangan</th>
            <th>Harga Satuan</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Tanggal</th>
            <th>Admin</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($restok as $re)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $re->id }}" /></td>
            <td>{{ $re->keterangan }}</td>
            <td>{{ number_format($re->harga) }}</td>
            <td>{{ $re->qty }}</td>
            <td>{{ number_format($re->harga * $re->qty) }}</td>
            <td>{{ date('d M Y', strtotime($re->tanggal)) }}</td>
            <td>{{ $re->admin->name }}</td>
            <td>
              <a onclick="return confirm('Batalkan Restok Barang Ini?');" href="{{ url('restok/delete/'.$re->id) }}">
              <button class="btn btn-danger" type="button"><i class="fa fa-remove"></i></button></a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-8">
            {{-- <button type="button" class="btn btn-success"><i class="fa fa-check"></i>&nbsp Post Check</button>
            <button type="button" class="btn btn-success"><i class="fa fa-check-circle-o"></i>&nbsp Post All</button> --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i>&nbsp Add Data</button>
          </div>
          <div class="col-md-4 push-right" style="font-size: 1.5em; font-weight: bold;">
            Total Penjualan : 
            {{-- Rp {{ number_format($penjualan->sum('grand_total')) }} --}}
          </div>
        </div>
        </form>
      </div>
    </div>
  </section>
</div>


{{-- MODAL ADD RESTOK DATA --}}
<div class="modal fade" id="modalAdd">
  <div class="modal-dialog">
    <form action="{{ url('restok/restoksave') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Restok Barang Penjualan</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Barang</label>
          <div class="col-sm-9">
            <select class="form-control select2" id="barang" name="barang" onchange="pilih()" style="width: 70%">
              <option selected="selected" value="-1">--- Pilih Barang ---</option>
              @foreach($brgs as $brg)
              <option value="{{ $brg->id.",".$brg->h_jual.",".$brg->hpp.",".$brg->stok }}">{{ $brg->nama }}</option>
              @endforeach
            </select>
            <input type="hidden" name="nmBrg" id="nmBrg">
            <input type="hidden" name="id" id="id">
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-6">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker" name="tgl" value="{{ $dateNow }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Beli</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="hBeli" name="hBeli"  oninput="getTotal()"/>
          </div>
          <div class="col-sm-5">
            <h4><div id="txtBeli"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Jual</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="hJual" name="hJual" oninput="hrg()" />
          </div>
          <div class="col-sm-5">
            <h4><div id="txtJual"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Qty</label>
          <div class="col-sm-3">
            <input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" min="1" value="1" oninput="getStok()" />
          </div>
          <div class="col-sm-3"><h4><div id="stok"> Stok : 0 Item</div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <h3><div id="total">Rp 0</div></h3>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-6">
            <textarea type="text" class="form-control" id="ket" name="ket" /></textarea>
          </div>
        </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  function pilih()
  {
    var arryId = $("#barang").find(":selected").val();
    if(arryId != "-1")
    {
      var nama = $("#barang").find(":selected").text();
      $("#nmBrg").val(nama);
      $("#barang").select2("close");
      var arry = arryId.split(',');
      $("#id").val(arry[0]);
      $("#hBeli").val(arry[2]);
      $("#hJual").val(arry[1]);
      $("#stok").text("Stok : "+arry[3]+" Item");
      getTotal();
      hrg();
    } 
  }

  function getTotal()
  {
    var total = $("#hBeli").val() * $("#qty").val();
    $("#total").text(convToRp(total));
    hrg();
  }

  function hrg()
  {
    $("#txtBeli").text(convToRp($("#hBeli").val()));
    $("#txtJual").text(convToRp($("#hJual").val()));
  }

  function getStok()
  {
    var arryId = $("#barang").find(":selected").val();
    var arry = arryId.split(',');
    var stok = parseInt(arry[3]) + parseInt($("#qty").val());
    $("#stok").text("Stok : "+stok+" Item");
    getTotal();
  }
</script>
@stop