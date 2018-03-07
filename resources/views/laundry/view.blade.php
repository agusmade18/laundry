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
    <div class="row">
      <div class="col-md-6">
        <h3><strong>Total Uang : Rp {{ number_format($lhs->sum('grand_total')) }}</strong></h3>
      </div>
      <div class="col-md-6">
        <div class="row" style="margin-top: 15px; margin-bottom: 5px;">
          <div class="col-md-3 pull-right" style="padding-left: 1px;padding-top: 1px;padding-bottom: 1px;">
            <a href="{{ url('laundry/canceledTransaksi') }}">
            <button type="button" class="btn btn-block btn-danger btn-lg"><i class="fa fa-trash"></i>&nbsp ( {{ $del->count('id') }} )</button> </a>
          </div>
          <div class="col-md-3 pull-right" style="padding: 1px;">
            <a href="{{ url('laundry/done') }}">
            <button type="button" class="btn btn-block btn-success btn-lg"><i class="fa fa-check"></i>&nbsp ( {{ $don->count('id') }} )</button> </a>
          </div>
          <div class="col-md-3 pull-right" style="padding: 1px;">
            <a href="{{ url('laundry/transaksi') }}">
              <button type="button pull-right" class="btn btn-block btn-primary btn-lg"><i class="fa fa-plus"></i></button>
            </a>
          </div>
        </div>
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
        <form method="post" action="{{ url('laundry/multipleDo') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Kode</th>
            <th>Data Customer</th>
            <th>Tgl Masuk</th>
            <th>Tgl Keluar</th>
            <th>Total</th>
            <th>Qty Brg</th>
            <th>Pembayaran</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($lhs as $lh)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $lh->id }}" /></td>
            <td><a href="{{ url('laundry/detail/'.$lh->kode) }}"> <span class="label label-primary"> {!! "&nbsp&nbsp".$lh->kode."&nbsp&nbsp" !!} </span> </a></td>
            <td>{{ $lh->myCustomer->nama }} ( 
                {{ $lh->myCustomer->phone }} ) /  
                {{ $lh->myCustomer->alamat }} <a href="{{ url('laundry/cetak/'.$lh->kode) }}"><button class="btn btn-info pull-right" type="button"><i class="fa fa-print"></i></button></a></td>
            <td>{{ date('d M Y', strtotime($lh->tgl_masuk)) }}</td>
            <td>{{ date('d M Y', strtotime($lh->tgl_keluar)) }}</td>
            <td>{{ number_format($lh->grand_total) }}</td>
            <td>
              @php($lDetail = App\LaundryDetail::has('barang')->where('kode', '=', $lh->kode)->get())
              @php($totQty = 0)
              @foreach($lDetail as $ld)
                @php($totQty = $totQty + ($ld->barang->qty*$ld->qty))
              @endforeach
              {{ $totQty." Pcs" }}
            <td>
              @if($lh->bayar >= $lh->grand_total)
              <span class="label label-success">Lunas</span>
              @elseif($lh->bayar <= 0)
              <span class="label label-danger">Belum Lunas</span>
              @endif
            </td>
            <td class="center">
              @if($lh->bayar >= $lh->grand_total)
                <a href="{{ url('laundry/done/'.$lh->kode) }}">
                  <button class="btn btn-success" type="button"><i class="fa fa-check"></i></button> 
                </a>
              @elseif($lh->bayar <= 0)
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalBayar" onclick="bayar('{{ $lh->kode }}', '{{ $lh->grand_total }}')"><i class="fa fa-check"></i></button>
              @endif
              <a onclick="return confirm('Batalkan Transaksi Ini?');" href="{{ url('laundry/batal/'.$lh->kode) }}">
              <button class="btn btn-danger" type="button"><i class="fa fa-remove"></i></button></a>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-1">
            <button type="submit" name="selesai" value="done" class="btn btn-success"><i class="fa fa-check" onclick="return confirm('Selesaikan Semua Transaksi ini?')">&nbsp Done</i></button>
          </div>
          <div class="col-md-1">
            <button type="submit" name="batal" value="batal" class="btn btn-danger"><i class="fa fa-remove" onclick="return confirm('Batalkan Semua Transaksi ini?')">&nbsp Batal</i></button>
          </div>
        </div>
        </form>
      </div>
      <!-- /.box-body -->
    </div>
  </section>

</div>

{{-- MODAL BAYAR --}}
<div class="modal fade" id="modalBayar">
  <div class="modal-dialog">
    <form action="{{ url('laundry/bayar') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Form Pembayaran</div></h4>
      </div>
      <div class="modal-body">

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Total Harga</label>
          <div class="col-sm-9">
            <h3><strong><div id="totalBayar"> Rp 0 </div></strong></h3>
            <input type="hidden" name="code" id="code" />
            <input type="hidden" name="tot" id="tot" />
          </div>
        </div>

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Diskon</label>
          <div class="col-sm-2" style="padding-right: 1px;">
            <input type="text" name="disP" id="disP" class="form-control" placeholder="Disc (%)" oninput="setDiskonPersen()" min="0" max="100" value="0" />
          </div>
          <div class="col-sm-4" style="padding-left: 1px;">
            <input type="number" name="disN" id="disN" class="form-control" placeholder="Disc (Rp)" oninput="setDiskonNominal()" value="0" />
          </div>
        </div>

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Bayar</label>
          <div class="col-sm-6">
            <input type="number" name="bayar" id="bayar" class="form-control" min="0" oninput="pay()" required autofocus />
          </div>
        </div>
        
        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Kembali</label>
          <div class="col-sm-6">
            <input type="hidden" name="total" id="total" />
            <h4> <div class="controls" id="txtTotal">Rp 0</div> </h4>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="simpan" disabled>Save changes</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  function bayar(kode, total)
  {
    $("#bayar").focus();
    $("#code").val(kode);
    $("#tot").val(total);
    $("#totalBayar").text(convToRp(total));
  }

  function setDiskonPersen()
  {
    var total = $("#tot").val();
    var disPersen = $("#disP").val();
    var disNominal = 0;
    disNominal = (total * disPersen) / 100;
    $("#disN").val(disNominal);
    getTotal();
  }

  function setDiskonNominal()
  {
    var total = $("#tot").val();
    var disNominal = $("#disN").val();
    var disPersen = 0;
    disPersen = (disNominal / total) * 100;
    $("#disP").val(disPersen.toFixed(1));
    getTotal();
  }

  function getTotal()
  {
    var total = $("#tot").val();
    var disNominal = $("#disN").val();
    var hasil = total - disNominal;
    $("#totalBayar").text(convToRp(hasil));
  }

  function pay()
  {
    var total = $("#tot").val();
    var disNominal = $("#disN").val();
    var hasil = total - disNominal;
    var bayar = $("#bayar").val();
    var result = bayar - hasil;
    $("#txtTotal").text(convToRp(result));
    if(result<0)
    {
      $(':input[type="submit"]').prop('disabled', true);
    } else {
      $(':input[type="submit"]').prop('disabled', false);
    }
  }
</script>

@stop
