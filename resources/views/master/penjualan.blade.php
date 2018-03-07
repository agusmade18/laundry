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
            <h3><strong>Master Barang Penjualan</strong></h3>
          </div>
          <div class="col-md-1 pull-right">
            <button type="button" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i></button>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <form method="post" action="{{ url('master/masterpenjualandeletem') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Nama Barang</th>
            <th>Hrg. Pokok</th>
            <th>Hrg. Jual</th>
            <th>Stok</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($brs as $br)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $br->id }}" /></td>
            <td>{{ $br->nama }}</td>
            <td>{{ number_format($br->hpp) }}</td>
            <td>{{ number_format($br->h_jual) }}</td>
            <td>{{ $br->stok." Unit" }}</td>
            <td>{{ $br->keterangan }}</td>
            <td>
              <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modalEdit" onclick="edit('{{ $br->id }}', '{{ $br->nama }}', '{{ $br->hpp }}', '{{ $br->h_jual }}', '{{ $br->stok }}', '{{ $br->keterangan }}')" ><i class="fa fa-pencil"></i></button>
              <a onclick="return confirm('Hapus Data Ini?');" href="{{ url('master/masterpenjualandelete/'.$br->id) }}">
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
    <form action="{{ url('master/masterpenjualansave') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data Master Barang Penjualan</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Barang</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="nama" name="nama" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Pokok</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="hpp" name="hpp"  oninput="rpL()"/>
          </div>
          <div class="col-sm-5">
            <h4><div id="txtL"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Jual</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="hJual" name="hJual" oninput="rpS()" />
          </div>
          <div class="col-sm-5">
            <h4><div id="txtS"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Stok</label>
          <div class="col-sm-6">
            <input type="number" min="0" value="0" class="form-control" id="stok" name="stok" placeholder="Disarankan 0 untuk barang pertama" />
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
    <form action="{{ url('master/masterpenjualanupdate') }}" method="post" class="form-horizontal">
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
          <label for="jenis" class="col-sm-3 control-label">Harga Pokok</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="edhpp" name="edhpp"  oninput="edrpL()"/>
          </div>
          <div class="col-sm-5">
            <h4><div id="edtxtL"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Jual</label>
          <div class="col-sm-4">
            <input type="number" min="0" class="form-control" id="edhJual" name="edhJual" oninput="edrpS()" />
          </div>
          <div class="col-sm-5">
            <h4><div id="edtxtS"></div></h4>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Stok/Barang</label>
          <div class="col-sm-6">
            <input type="number" min="0" class="form-control" id="edstok" name="edstok" />
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
    var value = $("#hpp").val();
    $("#txtL").text(convToRp(value));
  }

  function rpS()
  {
    var value = $("#hJual").val();
    $("#txtS").text(convToRp(value));
  }

  function edrpL()
  {
    var value = $("#edhpp").val();
    $("#edtxtL").text(convToRp(value));
  }

  function edrpS()
  {
    var value = $("#edhJual").val();
    $("#edtxtS").text(convToRp(value));
  }

  function edit(id, nama, hpp, hjual, stok, ket)
  {
    $("#id").val(id);
    $("#edNama").val(nama);
    $("#edhpp").val(hpp);
    $("#edhJual").val(hjual);
    $("#edstok").val(stok);
    $("#edKet").val(ket);
    $("#edtxtL").text(convToRp(hpp));
    $("#edtxtS").text(convToRp(hjual));
  }
</script>
@stop
