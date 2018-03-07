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
          <div class="col-md-11">
            <h3><strong>Master Biaya Bulanan</strong></h3>
          </div>
          <div class="col-md-1 pull-right">
            <button type="button" class="btn btn-block btn-primary btn-lg" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i></button>
          </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <form method="post" action="{{ url('master/biaya-bulanan-delete-multiple') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Nama Pengeluaran</th>
            <th>Harga</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($bbs as $bb)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $bb->id }}" /></td>
            <td>{{ $bb->nama }}</td>
            <td>{{ number_format($bb->biaya) }}</td>
            <td>{{ $bb->keterangan }}</td>
            <td>
              <button type="button" class="btn btn-warning" onclick="edit('{{ $bb->id }}', '{{ $bb->nama }}', '{{ $bb->biaya }}', '{{ $bb->keterangan }}')" data-toggle="modal" data-target="#modalEdit"><i class="fa fa-pencil"></i></button>
              <a href="{{ url('master/biaya-bulanan-delete/'.$bb->id) }}" onclick="return confirm('Hapus Data Ini???')">
              <button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button> </a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-1">
            <button type="submit" name="batal" value="batal" class="btn btn-danger"><i class="fa fa-remove" onclick="return confirm('Batalkan Semua Transaksi ini?')">&nbsp Hapus Master Biaya Bulanan</i></button>
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
    <form action="{{ url('master/biaya-bulanan-save') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data Master Biaya Bulanan</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Pengeluaran</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="nama" name="nama" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga</label>
          <div class="col-sm-4">
            <input type="text" min="0" class="form-control" id="harga" name="harga"  oninput="rpHarga()" required/>
          </div>
          <div class="col-sm-4">
            <h4><div id="hrg">Rp 0</div></h4>
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
  </div>
</div>


{{-- MODAL EDIT--}}
<div class="modal fade" id="modalEdit">
  <div class="modal-dialog">
    <form action="{{ url('master/biaya-bulanan-update') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Edit Data Master Biaya Bulanan</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Pengeluaran</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="edNama" name="edNama" required/>
            <input type="hidden" id="id" name="id" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga</label>
          <div class="col-sm-4">
            <input type="text" min="0" class="form-control" id="edHarga" name="edHarga"  oninput="edrpHarga()" required/>
          </div>
          <div class="col-sm-4">
            <h4><div id="edhrg">Rp 0</div></h4>
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
  </div>
</div>

<script type="text/javascript">
  function rpHarga()
  {
    var harga = convToRp($("#harga").val());
    $("#hrg").text(harga);
  }

  function edrpHarga()
  {
    var harga = convToRp($("#edHarga").val());
    $("#edhrg").text(harga);
  }

  function edit(id, nama, harga, ket)
  {
    $("#id").val(id);
    $("#edNama").val(nama);
    $("#edHarga").val(harga);
    $("#edKet").val(ket);
    edrpHarga();
  }
</script>
@stop
