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
        <form action="{{ url('biaya-bulanan/gaji-search/') }}" method="get">
        <div class="row">
          <div class="col-md-8">
            <h3><strong>Data Gaji Bulanan</strong></h3>
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
            <th>Nama Admin</th>
            <th>Gaji Pokok</th>
            <th>Bonus</th>
            <th>Potongan</th>
            <th>Total Gaji</th>
            <th>Tgl. Input</th>
            <th>Diinpt Oleh</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($gajis as $gaji)
          <tr>
            <td>{{ $gaji->admin->name }}</td>
            <td>{{ number_format($gaji->gaji_pokok) }}</td>
            <td>{{ number_format($gaji->tambahan) }}<br>{{ $gaji->ket_tambahan }}</td>
            <td>{{ number_format($gaji->potongan) }}<br>{{ $gaji->ket_potongan }}</td>
            <td>{{ number_format($gaji->total) }}</td>
            <td>{{ date('d M Y', strtotime($gaji->tanggal)) }}</td>
            <td>{{ $gaji->addby->name }}</td>
            <td>
              <a href="{{ url('biaya-bulanan/gaji/hapus/'.$gaji->id) }}" onclick="return confirm('Hapus Data Gaji Ini???')">
              <button type="button" class="btn btn-danger"><i class="fa fa-remove"></i></button> </a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i>&nbsp Tambah Gaji</button>
      </div>
    </div>
  </section>
</div>

{{-- MODAL ADD GAJI --}}
<div class="modal fade" id="modalAdd">
  <div class="modal-dialog">
    <form action="{{ url('biaya-bulanan/gaji/save') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data Gaji</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Admin</label>
          <div class="col-sm-9">
            <select class="form-control select2" id="admin" name="admin" style="width: 100%" onchange="pilih()" required>
              <option selected="selected" value="">--- Pilih Admin ---</option>
              @foreach($users as $usr)
              <option value="{{ $usr->id }}">{{ $usr->name }}</option>
              @endforeach
            </select>
            <input type="hidden" name="namaadm" id="namaadm">
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-9">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker" name="tgl" value="{{ $dateNow }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Gaji Pokok</label>
          <div class="col-sm-9">
            <input type="text" min="0" class="form-control" id="gPokok" name="gPokok" onchange="rupiah(1)" required placeholder="Gaji Pokok" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Bonus/Ketr.</label>
          <div class="col-sm-3">
            <input type="text" min="0" class="form-control" id="bonus" name="bonus" onchange="rupiah(2)" placeholder="Bonus" value="0" />
          </div>
          <div class="col-sm-6">
            <input type="text" min="0" class="form-control" id="ketBonus" name="ketBonus" placeholder="Keterangan Bonus"/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Potongan/Ketr.</label>
          <div class="col-sm-3">
            <input type="text" min="0" class="form-control"  value="0" id="potongan" name="potongan" onchange="rupiah(3)" placeholder="Potongan" />
          </div>
          <div class="col-sm-6">
            <input type="text" min="0" class="form-control" id="ketPotongan" name="ketPotongan" placeholder="Keterangan Potongan"/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total Gaji</label>
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

<script type="text/javascript">

  function pilih()
  {
    var adm = $("#admin").find(":selected").text();
    $("#namaadm").val(adm);
  }

  function rupiah(idx)
  {
    if(idx == 1)
    {
      $("#gPokok").val(convToRp($("#gPokok").val()));
    } else if(idx == 2)
    {
      $("#bonus").val(convToRp($("#bonus").val()));
    } else if(idx == 3)
    {
      $("#potongan").val(convToRp($("#potongan").val()));
    }
    total();
  }

  function total()
  {
    var gTotal = clearRp($("#gPokok").val());
    var bonus = clearRp($("#bonus").val());
    var potongan = clearRp($("#potongan").val());
    var hasil = parseInt(gTotal) + parseInt(bonus) - parseInt(potongan);
    $("#total").text(convToRp(hasil));
  } 

  function clearRp(str)
  {
    var result = str.replace('Rp ', '');
    result =  result.replace('.', '');
    result =  result.replace('.', '');
    return result;
  }
</script>
@stop
