@extends('layouts.index')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Penjualan
      <small>Transaksi</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Penjualan</li>
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

    <form action="{{ url('penjualan/saveDetail') }}" method="post" class="form-horizontal">
      {{ csrf_field() }}
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Barang</label>
          <div class="col-sm-7">
            <select class="form-control select2" id="barang" name="barang" onchange="pilih()">
              <option selected="selected" value="-1">--- Pilih Barang ---</option>
              @foreach($brgs as $brg)
              <option value="{{ $brg->id.",".$brg->h_jual }}">{{ $brg->nama }}</option>
              @endforeach
            </select>
            <input type="hidden" name="id" id="id" required>
          </div>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <label for="jenis" class="col-sm-3 control-label">Qty / Harga</label>
          <div class="col-sm-2">
            <input type="number" name="qty" id="qty" class="form-control" min="1" value="1" oninput="getTotal()" required>
          </div>
          <div class="col-sm-5">
            <input type="number" name="harga" id="harga" class="form-control" oninput="getTotal()" required>
          </div>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <label for="jenis" class="col-sm-3 control-label">Diskon (%)/(Rp)</label>
          <div class="col-sm-2">
            <input type="text" name="disP" id="disP" value="0" class="form-control" min="0" oninput="setDiskonP()" required>
          </div>
          <div class="col-sm-5">
            <input type="number" name="disN" id="disN" value="0" class="form-control" oninput="setDiskonN()" required>
          </div>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-4">
            <h3><div id="total">Rp 0</div></h3>
          </div>
          <div class="col-sm-3">
            <br><br>
            <button type="submit" class="btn btn-primary" disabled><i class="fa fa-save"></i> &nbsp Simpan</button>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <small>Total Belanja</small>
        <strong> <h1>Rp {{ number_format($pjDetails->sum('grand_total')) }}</h1></strong>
        <br><br><br>
        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modalBayar" onclick="byr({{ $pjDetails->sum('grand_total') }})" {{ $pjDetails->sum('grand_total') == 0 ? 'disabled' : '' }}><i class="fa  fa-opencart"></i> &nbsp Check Out</button>
      </div>
    </div>
    </form>

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            List Barang Penjualan
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <form method="post" action="{{ url('laundry/multipleDo') }}">
            {{ csrf_field() }}
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Diskon</th>
                <th>Total</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>
              @foreach($pjDetails as $pjd)
              <tr>
                <td>{{ $pjd->kode }}</td>
                <td>{{ $pjd->barang->nama }}</td>
                <td>{{ number_format($pjd->harga) }}</td>
                <td>{{ $pjd->qty }}</td>
                <td>{{ $pjd->diskon_persen."%/Rp ".number_format($pjd->diskon_nominal) }}</td>
                <td>{{ number_format($pjd->grand_total) }}</td>
                <td>
                  <a onclick="return confirm('Batalkan Transaksi Ini?');" href="{{ url('penjualan/deletedetail/'.$pjd->id) }}">
                  <button class="btn btn-danger" type="button"><i class="fa fa-remove"></i></button></a>
                </td>
              </tr>
              @endforeach
              </tbody>
            </table>
            </form>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
</div>


{{-- MODAL BAYAR --}}
<div class="modal fade" id="modalBayar">
  <div class="modal-dialog">
    <form action="{{ url('penjualan/saveHeader') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Check Out Penjualan</div></h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <h3><div id="mdTotal">Rp 0</div></h3>
          </div>
        </div>

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Tanggal</label>
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
          <label for="qty" class="col-sm-3 control-label">Diskon</label>
          <div class="col-sm-2" style="padding-right: 1px;">
            <input type="text" name="disTotP" id="disTotP" class="form-control" placeholder="Diskon (%)" oninput="setDiskonPersen({{ $pjDetails->sum('grand_total') }})" min="0" value="0" max="100" required />
          </div>
          <div class="col-sm-4" style="padding-left: 1px;">
            <input type="number" name="disTotN" id="disTotN" class="form-control" placeholder="Diskon (Rp)" value="0" oninput="setDiskonNominal({{ $pjDetails->sum('grand_total') }})" required />
          </div>
        </div>
        
        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Bayar</label>
          <div class="col-sm-3" style="padding-right: 1px;">
            <input type="number" name="bayar" id="bayar" class="form-control" min="0" value="0" oninput="inputBayar({{ $pjDetails->sum('grand_total') }})" required/>
          </div>
          <div class="col-sm-4">
            <h4><div id="txtByr"> Rp 0 </div></h4>
          </div>
        </div>        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Kembali</label>
          <div class="col-sm-6">
            <input type="hidden" name="total" id="total" />
            <h3> <div class="controls" id="txtTotal">Rp 0</div> </h3>
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
      $(':input[type="submit"]').prop('disabled', false);
      $("#barang").select2("close");
      var arry = arryId.split(',');
      $("#id").val(arry[0]);
      $("#harga").val(arry[1]);

      getTotal();
    } else {
      $(':input[type="submit"]').prop('disabled', true);
    }
  }

  function setDiskonP()
  {
    var total = ($("#harga").val() * $("#qty").val());
    var disP = $("#disP").val();
    var disNominal = 0;
    disNominal = (total * disP) / 100;
    $("#disN").val(disNominal);
    $("#total").text(convToRp(total-disNominal));
  }

  function setDiskonN()
  {
    var total = ($("#harga").val() * $("#qty").val());
    var disN = $("#disN").val();
    var disPersen = 0;
    disPersen = (disN / total) * 100;
    $("#disP").val(disPersen.toFixed(1));
    $("#total").text(convToRp(total-disN));
  }

  function setDiskonPersen(total)
  {
    var disP = $("#disTotP").val();
    var disNominal = 0;
    disNominal = (total * disP) / 100;
    $("#disTotN").val(disNominal);
    $("#mdTotal").text(convToRp(total-disNominal));
  }

  function setDiskonNominal(total)
  {
    var disN = $("#disTotN").val();
    var disPersen = 0;
    disPersen = (disN / total) * 100;
    $("#disTotP").val(disPersen.toFixed(1));
    $("#mdTotal").text(convToRp(total-disN));
  }

  function getTotal()
  {
    var total = ($("#harga").val() * $("#qty").val())-$("#disN").val();
    $("#total").text(convToRp(total));
  }

  function byr(total)
  {
    $("#mdTotal").text(convToRp(total));
  }

  function inputBayar(total)
  {
    var result = total - $("#disTotN").val();
    var hasil = $("#bayar").val()-result;
    $("#txtByr").text(convToRp($("#bayar").val()));
    $("#txtTotal").text(convToRp(hasil));
  }
</script>
@stop