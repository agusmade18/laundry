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
    <div class="box">
      <div class="box-header">
        @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h4><i class="icon fa fa-check"></i> Sukses...! {{ Session::get('message') }}</h4>
        </div>
        @endif
        <div class="row">
          <div class="col-md-11">
            <h3><strong>Master Barang Laundry</strong></h3>
          </div>
          <div class="col-md-1 pull-right">
            <button type="button" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i></button>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <form method="post" action="{{ url('master/laundry-delete-m') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Nama Barang</th>
            <th>Hrg. Laundry</th>
            <th>Hrg. Setrika</th>
            <th>Qty</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($bms as $bm)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $bm->id }}" /></td>
            <td>{{ $bm->nama }}</td>
            <td>{{ number_format($bm->harga_laundry) }}</td>
            <td>{{ number_format($bm->harga_setrika) }}</td>
            <td>{{ $bm->qty." Pcs" }}</td>
            <td>{{ $bm->keterangan }}</td>
            <td>
              <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modalEdit" onclick="edit('{{ $bm->id }}', '{{ $bm->nama }}', '{{ $bm->harga_laundry }}', '{{ $bm->harga_setrika }}', '{{ $bm->qty }}', '{{ $bm->keterangan }}')" ><i class="fa fa-pencil"></i></button>
              <a onclick="return confirm('Hapus Data Ini?');" href="{{ url('master/laundry-delete/'.$bm->id) }}">
              <button class="btn btn-danger" type="button"><i class="fa fa-remove"></i></button></a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-1">
            <button type="submit" name="batal" value="batal" class="btn btn-danger"><i class="fa fa-remove" onclick="return confirm('Batalkan Semua Transaksi ini?')">&nbsp Hapus Master Barang</i></button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </section>
</div>


{{-- MODAL ADD--}}
<div class="modal fade" id="modalAdd">
  <div class="modal-dialog">
    <form action="{{ url('master/laundrySave') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data Master Laundry</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Barang</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="nama" name="nama" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Laundry</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="hLaundry" name="hLaundry"  oninput="rpL()"/>
          </div>
          <div class="col-sm-5">
            <h4><div id="txtL"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Setrika</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="hSetrika" name="hSetrika" oninput="rpS()" />
          </div>
          <div class="col-sm-5">
            <h4><div id="txtS"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Qty/Barang</label>
          <div class="col-sm-6">
            <input type="number" min="1" value="1" class="form-control" id="qty" name="qty" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-6">
            <textarea type="text" class="form-control" id="ket" name="ket" /> </textarea>
          </div>
        </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


{{-- MODAL EDIT--}}
<div class="modal fade" id="modalEdit">
  <div class="modal-dialog">
    <form action="{{ url('master/laundryUpdate') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Edit Data Master Laundry</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Barang</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="edNama" name="edNama" />
            <input type="hidden" id="id" name="id" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Laundry</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="edHLaundry" name="edHLaundry"  oninput="edrpL()"/>
          </div>
          <div class="col-sm-5">
            <h4><div id="edtxtL"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Setrika</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="edHSetrika" name="edHSetrika" oninput="edrpS()" />
          </div>
          <div class="col-sm-5">
            <h4><div id="edtxtS"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Qty/Barang</label>
          <div class="col-sm-6">
            <input type="number" min="1" value="1" class="form-control" id="edQty" name="edQty" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-6">
            <textarea type="text" class="form-control" id="edKet" name="edKet" /> </textarea>
          </div>
        </div>

        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
  function rpL()
  {
    var value = $("#hLaundry").val();
    $("#txtL").text(convToRp(value));
  }

  function rpS()
  {
    var value = $("#hSetrika").val();
    $("#txtS").text(convToRp(value));
  }

  function edrpL()
  {
    var value = $("#edHLaundry").val();
    $("#edtxtL").text(convToRp(value));
  }

  function edrpS()
  {
    var value = $("#edHSetrika").val();
    $("#edtxtS").text(convToRp(value));
  }

  function edit(id, nama, hL, hS, qty, ket)
  {
    $("#id").val(id);
    $("#edNama").val(nama);
    $("#edHLaundry").val(hL);
    $("#edHSetrika").val(hS);
    $("#edQty").val(qty);
    $("#edKet").val(ket);
  }
</script>
@stop
