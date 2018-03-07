@extends('layouts.index')
@section('content')

@if(Request::segment(2) == "kerugian")
@php($title = "Kerugian")
@php($jns = "0")
@elseif(Request::segment(2) == "other-income")
@php($title = "Other Income")
@php($jns = "1")
@else
  @if(Request::get('jenis') == "kerugian")
    @php($title = "Kerugian")
    @php($jns = "0")
  @elseif(Request::get('jenis') == "other-income")
    @php($title = "Other Income")
    @php($jns = "1")
  @endif
@endif

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Other
      <small>{{ $title }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">{{ $title }}</li>
    </ol>
  </section>
  
  <section class="content">
    <div class="row" style="padding: 1px;">
      <div class="col-md-8">
        <h3><strong>Data {{ $title }}</strong></h3>
      </div>
      <form action="{{ url('other/search') }}" method="GET">
      <div class="col-md-3">
        <label class="control-label">Tanggal</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="hidden" name="jenis" id="jenis" value="{{ Request::segment(2) == 'search' ? Request::get('jenis') : Request::segment(2) }}">
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
          @foreach($ots as $ot)
          <tr>
            <td></td>
            <td>{{ $ot->nama }}</td>
            <td>{{ number_format($ot->harga) }}</td>
            <td>{{ $ot->qty }}</td>
            <td>{{ number_format($ot->total) }}</td>
            <td>{{ date('d M Y', strtotime($ot->tanggal)) }}</td>
            <td>{{ $ot->admin->name }}</td>
            <td>
              <button type="button" class="btn btn-warning" onclick="edit('{{ $ot->id }}', '{{ $ot->nama }}', '{{ $ot->qty }}', '{{ $ot->tanggal }}', '{{ $ot->harga }}')" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-pencil"></i></button>
              
              <a href="{{ url('othr/delete/'.$ot->id) }}"> <button type="button" class="btn btn-danger" onclick="" ><i class="fa fa-remove"></i></button> </a>
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
            Total {{ $title }} : Rp {{ $ots->sum('total') }}
            {{-- Rp {{ number_format($penjualan->sum('grand_total')) }} --}}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


{{-- MODAL ADD DATA --}}
<div class="modal fade" id="modalAdd">
  <div class="modal-dialog">
    <form action="{{ url('other/save') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data {{ $title }}</div></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="ket" name="ket" required />
            <input type="hidden" id="jenis" name="jenis" value="{{ $jns }}" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-7">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker" name="tgl" value="{{ $dateNow }}" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Satuan</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="harga" name="harga" oninput="rpHrg()" required/>
          </div>
          <div class="col-sm-5">
            <h4><div id="txtHrg">Rp 0</div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Qty</label>
          <div class="col-sm-4">
            <input type="number" min="1" value="1" class="form-control" id="qty" name="qty" oninput="getTotal()" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <h3><div id="total">Rp 0</div></h3>
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


{{-- MODAL EDIT DATA --}}
<div class="modal fade" id="modalEdit">
  <div class="modal-dialog">
    <form action="{{ url('other/update') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Edit Data {{ $title }}</div></h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" id="edKet" name="edKet" required />
            <input type="hidden" id="edJenis" name="edJenis" value="{{ $jns }}" />
            <input type="hidden" id="id" name="id" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-7">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker2" name="edTgl" value="{{ $dateNow }}" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Satuan</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="edHarga" name="edHarga" oninput="edrpHrg()" required/>
          </div>
          <div class="col-sm-5">
            <h4><div id="edtxtHrg">Rp 0</div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Qty</label>
          <div class="col-sm-4">
            <input type="number" min="1" value="1" class="form-control" id="edQty" name="edQty" oninput="edgetTotal()" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <h3><div id="edtotal">Rp 0</div></h3>
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
  function rpHrg()
  {
    var hasil = convToRp($("#harga").val());
    $("#txtHrg").text(hasil);
    getTotal();
  }

  function getTotal()
  {
    var qty = $("#qty").val();
    var harga = $("#harga").val();
    var hasil = qty * harga;
    $("#total").text(convToRp(hasil));
  }


  function edrpHrg()
  {
    var hasil = convToRp($("#edHarga").val());
    $("#edtxtHrg").text(hasil);
    edgetTotal();
  }

  function edgetTotal()
  {
    var qty = $("#edQty").val();
    var harga = $("#edHarga").val();
    var hasil = qty * harga;
    $("#edtotal").text(convToRp(hasil));
  }

  function edit(id, nama, qty, tanggal, harga)
  {
    $("#id").val(id);
    $("#edKet").val(nama);
    $("#edQty").val(qty);
    $("#edHarga").val(harga);

    var dt = tanggal.split('-');
    var tgl = dt[1]+"/"+dt[2]+"/"+dt[0];
    $("#datepicker2").val(tgl);
    edrpHrg();
  }
</script>
@stop