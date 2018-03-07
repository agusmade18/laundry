@extends('layouts.index')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Arus Kas
      <small>Kas Kecil Rincian</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Arus Kas</a></li>
      <li class="active">Kas Kecil</li>
    </ol>
  </section>
  
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <h3><strong>Laporan Kas Kecil (Rincian)</strong></h3>
      </div>
      <div class="col-md-6 pull-right">
        <h3><strong>Total Pengeluaran : Rp {{ number_format($kks->sum('total')) }}</strong></h3>
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
        <form method="post" action="{{ url('aruskas/multipleDelete') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Kode</th>
            <th>Nama Pengeluaran</th>
            <th>Tgl</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($kks as $kk)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $kk->id }}" /></td>
            <td>{{ $kk->kode }}</td>
            <td>{{ $kk->nama }}</td>
            <td>{{ date('d M Y', strtotime($kk->tanggal)) }}</td>
            <td>{{ number_format($kk->harga) }}</td>
            <td>{{ $kk->qty }}</td>
            <td>{{ number_format($kk->total) }}</td>
            <td>{{ $kk->keterangan }}</td>
            <td>
              <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modalEdit" onclick="editData('{{ $kk->id }}', '{{ $kk->kode }}', '{{ $kk->nama }}', '{{ $kk->qty }}', '{{ $kk->keterangan }}', '{{ $kk->harga }}', '{{ $kk->tanggal }}')"><i class="fa fa-pencil"></i></button>
              <a onclick="return confirm('Hapus Pengeluaran Ini?');" href="{{ url('aruskas/delete/'.$kk->id) }}">
              <button class="btn btn-danger" type="button"><i class="fa fa-remove"></i></button></a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-1">
            <button type="button" name="selesai" value="done" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus">&nbsp Tambah</i></button>
          </div>
          <div class="col-md-2" style="padding-right: 1px;">
            <a href="{{ url('aruskas/export') }}">
            <button type="button" class="btn btn-success"><i class="fa fa-upload">&nbsp Export ke Kas Besar</i></button> </a>
          </div>
          <div class="col-md-1" style="padding-left: 1px;">
            <button type="submit" name="batal" value="batal" class="btn btn-danger" onclick="return confirm('Hapus Semua Pengeluaran ini?')"><i class="fa fa-remove">&nbsp Hapus</i></button>
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
    <form action="{{ url('aruskas/kaskecilSave') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data Pengeluaran</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Pengeluaran</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="nama" name="nama" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-6">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" value="{{ $dateNow }}" id="datepicker" name="tgl">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Satuan</label>
          <div class="col-sm-6">
            <input type="number" min="0" class="form-control" id="harga" name="harga" oninput="getTotal()" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Qty</label>
          <div class="col-sm-6">
            <input type="number" min="1" value="1" class="form-control" id="qty" name="qty" oninput="getTotal()" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="total" name="total" value="Rp 0" disabled />
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
    <form action="{{ url('aruskas/kaskecilUpdate') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Edit Data Pengeluaran</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Pengeluaran</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="edNama" name="edNama" required/>
            <input type="hidden" id="id" name="id"/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-6">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" value="" id="datepicker2" name="edTgl">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Harga Satuan</label>
          <div class="col-sm-6">
            <input type="number" min="0" class="form-control" id="edHarga" name="edHarga" oninput="edGetTotal()" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Qty</label>
          <div class="col-sm-6">
            <input type="number" min="1" value="1" class="form-control" id="edQty" name="edQty" oninput="edGetTotal()" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="edTotal" name="edTotal" value="Rp 0" disabled />
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
  function getTotal()
  {
    var harga = $("#harga").val();
    var qty = $("#qty").val();
    var total = harga * qty;
    $("#total").val(convToRp(total));
  }

  function edGetTotal()
  {
    var harga = $("#edHarga").val();
    var qty = $("#edQty").val();
    var total = harga * qty;
    $("#edTotal").val(convToRp(total));
  }

  function editData(id, kode, nama, qty, ket, harga, tanggal)
  {
    $("#id").val(id);
    $("#kode").val(kode);
    $("#edNama").val(nama);
    $("#edHarga").val(harga);
    $("#edTotal").val(convToRp(harga*qty));
    $("#edQty").val(qty);
    $("#edKet").val(ket);
    var tgl = tanggal.split('-');
    var myTgl = tgl[1]+"/"+tgl[2]+"/"+tgl[0];
    $("#datepicker2").val(myTgl);
  }
</script>
@stop
