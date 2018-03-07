@extends('layouts.index')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Biaya Bulanan
      <small>Rutin</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Biaya Bulanan</li>
    </ol>
  </section>

  <section class="content">

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
        <form action="{{ url('biaya-bulanan/bb/') }}" method="get">
        <div class="row">
          <div class="col-md-8">
            <h3><strong>Data Biaya Bulanan</strong></h3>
          </div>
          <div class="col-md-2">
            <label class="control-label">Bulan</label>
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <select class="form-control" id="bulan" name="bulan">
                @foreach($bulans as $bulan)
                <option value="{{ $bulan->id }}" {{ $month ==  $bulan->id ? 'selected' : ''}}> {{ $bulan->nama }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <form action="" method="get">
            <label class="control-label">Tahun</label>
            <div class="input-group">
              <input type="number" name="tahun" id="tahun" class="form-control" value="{{ $year }}">
              <span class="input-group-btn">
                <button type="submit" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
            </form>
          </div>
        </div>
        </form>
      </div>
      <!-- /.box-header -->
      <div class="box-body table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nama Pengeluaran</th>
            <th>Hrg. Dasar</th>
            <th>Dibayarkan</th>
            <th>Tgl. Bayar</th>
            <th>Keterangan</th>
            <th>Diinpt Oleh</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($bbs as $bb)
          @php($bBulanan = App\BiayaBulanan::whereMonth('tanggal', '=', $month)->where('id_master', '=', $bb->id)->first())
          <tr>
            <td>{{ $bb->nama }}</td>
            <td>{{ number_format($bb->biaya) }}</td>
            <td>{{ count($bBulanan) ? number_format($bBulanan->harga) : '0' }}</td>
            <td>{{ count($bBulanan) ? date('d M Y', strtotime($bBulanan->tanggal)) : '-' }}</td>
            <td>{{ count($bBulanan) ? $bBulanan->keterangan : '-' }}</td>
            <td>{{ count($bBulanan) ? $bBulanan->admin->name : '-' }}</td>
            <td>
              @if(count($bBulanan))
                <button type="button" class="btn btn-danger" disabled><i class="fa fa-lock"></i></button>
                <a href="" onclick="edit('{{ $bBulanan->id }}', '{{ $bBulanan->nama }}', '{{ $bBulanan->harga }}')"  data-toggle="modal" data-target="#modalEdit"> Edit </a>
              @else
                <button type="button" class="btn btn-success" onclick="bayar('{{ $bb->id }}', '{{ $bb->nama }}', '{{ $bb->biaya }}')"  data-toggle="modal" data-target="#modalAdd"><i class="fa fa-money"></i></button>
              @endif
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

{{-- MODAL ADD --}}
<div class="modal fade" id="modalAdd">
  <div class="modal-dialog">
    <form action="{{ url('biaya-bulanan/bb/save') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pembayaran Biaya Bulanan</h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Pengeluaran</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="nama" name="nama" required />
            <input type="hidden" id="id" name="id" />
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


{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit">
  <div class="modal-dialog">
    <form action="{{ url('biaya-bulanan/bb/update') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Pembayaran Biaya Bulanan</h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Pengeluaran</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="edNama" name="edNama" required />
            <input type="hidden" id="edId" name="edId" />
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
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-6">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" value="{{ $dateNow }}" id="datepicker2" name="edTgl">
            </div>
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
  function bayar(id, nama, harga)
  {
    $("#nama").val(nama);
    $("#id").val(id);
    $("#harga").val(harga);
    rpHarga();
  }

  function edit(id, nama, harga)
  {
    $("#edNama").val(nama);
    $("#edId").val(id);
    $("#edHarga").val(harga);
    edrpHarga();
  }

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
</script>
@stop