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
      <h4><i class="icon fa fa-check"></i> Sukses...! {{ Session::get('message') }}</h4>
    </div>
    @endif
    <div class="row">
      <section class="col-lg-3 connectedSortable">
        <form name="formBarang" id="formBarang" action="{{ url('laundry/saveHeader') }}" method="post">
        {{ csrf_field() }}
        <div class="box box-success">
          <div class="box-header">
            Data Customer
          </div>
          <div class="box-body">
            <div class="form-group">
              <label>Nama Customer</label>
              <input type="text" name="namaCust" id="namaCust" class="form-control" placeholder="Nama Customer" required />
            </div>
            <div class="form-group">
              <label>Alamat</label>
              <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
            </div>
            <div class="form-group">
              <label>No. Telephopne</label>
              <input type="text" name="phone" id="phone" class="form-control" placeholder="No Telephone" />
            </div>
            <div class="form-group">
              <label>Keterangan Khusus</label>
              <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan"></textarea>
            </div>
            <div class="form-group">
              <label>Tanggal Pengambilan</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" value="{{ $dateNow }}" id="datepicker" name="tglAmbil">
              </div>
            </div>
            <div class="form-group">
              <label>Diskon</label>
              <div class="row">
                <div class="col-md-6" style="padding-right: 1px;"><input type="text" name="disTotalP" id="disTotalP" class="form-control" placeholder="Diskon (%)" min="0" oninput="discTotalPersen({{ $lDetails->sum('total') }})" /></div>
                <div class="col-md-6" style="padding-left: 1px;">
                  <input type="number" name="disTotalN" id="disTotalN" class="form-control" placeholder="Diskon (Rp)" min="0" oninput="discTotalNominal({{ $lDetails->sum('total') }})" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Bayar</label>
              <input type="number" name="bayar" id="bayar" class="form-control" placeholder="Bayar" oninput="bayarProses({{ $lDetails->sum('total') }})" value="0" required />
            </div>
          </div>
          <div class="box-footer">
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
          </div>
        </div>
        </form>
      </section>

      <section class="col-lg-9 connectedSortable">
        <div class="box box-primary">
          <div class="box-header">
            <div class="form-horizontal">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Data Barang</label>
                <div class="col-sm-10">
                  <select class="form-control select2" id="barang" name="barang" onchange="pilih()">
                    <option selected="selected" value="-1">--- Pilih Barang ---</option>
                    @foreach($bms as $bm)
                    <option value="{{ $bm->id.",".$bm->harga_laundry.",".$bm->harga_setrika.",".$bm->qty }}"><h1>{{ $bm->nama }}</h1></option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="box-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="10">No</th>
                  <th width="80">Nama Barang</th>
                  <th width="50">Harga</th>
                  <th width="10">Qty</th>
                  <th width="20">Disc</th>
                  <th width="50">Total</th>
                  <th width="20">Jenis</th>
                  <th width="10">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($lDetails as $ld)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td>{{ $ld->barang->nama }}</td>
                  <td>{{ number_format($ld->harga) }}</td>
                  <td>{{ $ld->qty }}</td>
                  <td>{{ $ld->diskon_persen == "" ? '0' : $ld->diskon_persen }}% / {{ $ld->diskon_nominal == "" ? '0' : number_format($ld->diskon_nominal) }}</td>
                  <td>{{ number_format($ld->total) }}</td>
                  <td>
                    @if($ld->jenis == "setrika")
                    <span class="label label-warning">{{ $ld->jenis }}</span>
                    @else
                    <span class="label label-info">{{ $ld->jenis }}</span>
                    @endif
                    </td>
                  <td>
                    <a href="{{ url('laundry/hapus/'.$ld->id) }}" onclick="return confirm('Hapus Data Ini?')">
                    <button class="btn btn-danger btn-mini"><i class="fa fa-remove"></i></button> </a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-4"><h5>Total Harga</h5></div>
              <div class="col-md-8"><h4>Rp {{ number_format($lDetails->sum('total')) }}</h4></div>
            </div>
            <div class="row">
              <div class="col-md-4"><h5>Qty Barang</h5></div>
              <div class="col-md-8"><h4>
                @foreach($lDetails as $ld)
                  @php($totQty = $totQty + ($ld->barang->qty*$ld->qty))
                @endforeach
                {{ $totQty." Pcs" }}
              </h4></div>
            </div>
            <div class="row">
              <div class="col-md-4"><h5>Diskon</h5></div>
              <div class="col-md-8"><h4><div id="totalDiskon">0% / Rp 0</div></h4></div>
            </div>
            <div class="row">
              <div class="col-md-4"><h5>Grand Total</h5></div>
              <div class="col-md-8"><h4><div id="gTotal" style="font-weight: bold;">Rp {{ number_format($lDetails->sum('total')) }}</div></h4></div>
            </div>
            <div class="row">
              <div class="col-md-4"><h5>Bayar</h5></div>
              <div class="col-md-8"><h4><div id="tBayar">Rp 0</div></h4></div>
            </div>
            <div class="row">
              <div class="col-md-4"><h5><div id="txtSisa">Sisa / Kembali</div></h5></div>
              <div class="col-md-8"><h4><div id="sisa">Rp {{ number_format($lDetails->sum('total')) }}</div></div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>
</div>

{{-- MODAL --}}
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <form action="{{ url('laundry/saveDetail') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="txtNama">Default Modal</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Jenis Transaksi</label>
          <div class="col-sm-6">
            <input type="hidden" id="id" name="id" />
            <select class="form-control" name="jenis" id="jenis" onchange="setHarga()">
              <option value="laundry">Laundry</option>
              <option value="setrika">Setrika</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Qty</label>
          <div class="col-sm-4">
            <input type="number" min="1" value="1" name="qty" id="qty" placeholder="Qty" oninput="setQty()" class="form-control" required autofocus>
          </div>
          <div class="col-sm-5">
            <div id="txtQty" style="padding-top: 5px; font-weight: bold;">Total Qty : </div>
          </div>
        </div>

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Harga</label>
          <div class="col-sm-4">
            <input type="number" class="form-control" id="harga" name="harga" min="0" placeholder="Harga" oninput="rubahHargaKeRp()" />
          </div>
          <div class="col-sm-5">
            <div id="txtHrg" style="padding-top: 5px; font-weight: bold;">Rp 0</div>
          </div>
        </div>

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Jasa Tambahan</label>
          <div class="col-sm-9" style="margin-top: 10px;">
            <input type="checkbox" name="hanger" id="hanger" onchange="grandTotal()" />&nbsp&nbsp&nbspHanger (Rp 1,500/Pcs)&nbsp&nbsp&nbsp
            <input type="checkbox" name="express" id="express" onchange="grandTotal()" />&nbsp&nbsp&nbspExpress (Rp 3,000/Pcs)
          </div>
        </div>

        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Diskon</label>
          <div class="col-sm-2" style="padding-right: 1px;">
            <input type="text" name="disP" id="disP" class="form-control" placeholder="Diskon (%)" oninput="setDiskonPersen()" min="0" max="100" />
          </div>
          <div class="col-sm-4" style="padding-left: 1px;">
            <input type="number" name="disN" id="disN" class="form-control" placeholder="Diskon (Rp)" oninput="setDiskonNominal()" />
          </div>
        </div>
        
        <div class="form-group">
          <label for="qty" class="col-sm-3 control-label">Total Harga</label>
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
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  function pilih()
  {
    $("#qty").select();
    var arryId = $("#barang").find(":selected").val();
    if(arryId != "-1")
    {
      $("#barang").select2("close");
      var arry = arryId.split(',');
      var nama = $("#barang").find(":selected").text();
      var jenis =  $("#jenis").find(":selected").val();
      var hrg = 0;
      if(jenis == "laundry")
      {
        hrg = arry[1];
      } else {
        hrg = arry[2];
      }
      
      $("#txtNama").text(nama);
      $("#id").val(arry[0]);
      $("#harga").val(hrg);
      $("#txtQty").text("Total Qty : "+arry[3]);
      $('#myModal').modal("toggle");
      rubahHargaKeRp();
      grandTotal();
    }
  }

  function setHarga()
  {
    var arryId = $("#barang").find(":selected").val();
    var arry = arryId.split(',');
    var jenis =  $("#jenis").find(":selected").val();
    var qty = $("#qty").val();
    var disPersen = $("#disP").val();
    var disNominal = $("#disN").val();
    var diskon = 0;

    var hrg = 0;
    if(jenis == "laundry")
    {
      hrg = arry[1];
    } else {
      hrg = arry[2];
    }

    var total = qty*hrg;
    if(disPersen != 0)
    {
      diskon = (total * disPersen) / 100;
      $("#disN").val(diskon);
    }
    $("#harga").val(hrg);
    $("#txtHrg").text(convToRp(hrg));

    grandTotal();
  }

  function rubahHargaKeRp()
  {
    var arryId = $("#barang").find(":selected").val();
    var hrg = $("#harga").val();
    var qty = $("#qty").val();
    var diskon = $("#disN").val();
    $("#txtHrg").text(convToRp(hrg));



    // $("#txtTotal").text(convToRp((qty*hrg)-diskon));
    // $("#total").val((qty*hrg)-diskon);

    grandTotal();
  }

  function setQty()
  {
    var arryId = $("#barang").find(":selected").val();
    var arry = arryId.split(',');
    var myQty = $("#qty").val();
    var hrg = $("#harga").val();
    var jenis = $('input[name=jenis]:selected').val();
   
    $("#txtQty").text("Total Qty : "+ myQty*arry[3]);
    // if($("#barang").find(":selected").text() == "Pakaian" && myQty<5 && jenis == "laundry")
    // {
    //   $("#harga").val(2000);
    // } 
    // else {
    //   $("#harga").val(1000);
    // }

    // if($("#barang").find(":selected").text() == "Pakaian" && myQty<5 && jenis == "setrika") {
    //   $("#harga").val(1200);
    // } else {
    //   $("#harga").val(600);
    // }

    if(jenis == "laundry" || jenis=="")
    {
      hrg = arry[1];
    } else {
      hrg = arry[2];
    }


    // $("#txtTotal").text(convToRp((myQty*hrg)-diskon));
    // $("#total").val((myQty*hrg)-diskon);
    grandTotal();
  }

  function setDiskonPersen()
  {
    var myQty = $("#qty").val();
    var hrg = $("#harga").val();
    var hanger = 0;
    var express = 0;
    if($('input:checkbox[name=hanger]').is(':checked'))
    {
      hanger = 1500 * myQty;
      $("#hanger").val(hanger);
    } else {
      hanger = 0;
      $("#hanger").val("0");
    }

    if($('input:checkbox[name=express]').is(':checked'))
    {
      express = 3000 * myQty;
      $("#express").val(express);
    } else {
      express = 0;
      $("#express").val("0");
    }
    var total = (myQty*hrg)+parseInt(hanger)+parseInt(express);
    var disPersen = $("#disP").val();

    var disNominal = 0;
    

    disNominal = (total * disPersen) / 100;
    //alert(disNominal);
    $("#disN").val(disNominal);
    grandTotal();
    
  }

  function setDiskonNominal()
  {
    var myQty = $("#qty").val();
    var hrg = $("#harga").val();
    var hanger = 0;
    var express = 0;
    if($('input:checkbox[name=hanger]').is(':checked'))
    {
      hanger = 1500 * myQty;
      $("#hanger").val(hanger);
    } else {
      hanger = 0;
      $("#hanger").val("0");
    }

    if($('input:checkbox[name=express]').is(':checked'))
    {
      express = 3000 * myQty;
      $("#express").val(express);
    } else {
      express = 0;
      $("#express").val("0");
    }
    var total = (myQty*hrg)+parseInt(hanger)+parseInt(express);
    var disNominal = $("#disN").val();

    var disPersen = 0;
    disPersen = (disNominal / total) * 100;
    $("#disP").val(disPersen.toFixed(1));
    grandTotal();
  }

  function grandTotal()
  {
    var harga = $("#harga").val();
    var qty = $("#qty").val();
    var diskon = $("#disN").val();
    var hanger = 0;
    var express = 0;
    if($('input:checkbox[name=hanger]').is(':checked'))
    {
      hanger = 1500 * qty;
      $("#hanger").val(hanger);
    } else {
      hanger = 0;
      $("#hanger").val("0");
    }

    if($('input:checkbox[name=express]').is(':checked'))
    {
      express = 3000 * qty;
      $("#express").val(express);
    } else {
      express = 0;
      $("#express").val("0");
    }
    
    var hasil = (harga * qty)+parseInt(hanger)+parseInt(express)-diskon;
    $("#total").val(hasil);
    $("#txtTotal").text(convToRp(hasil));
  }

  function discTotalPersen(total)
  {
    var disPersen = $("#disTotalP").val();
    var disNominal = 0;
    disNominal = (total * disPersen) / 100;
    $("#disTotalN").val(disNominal);
    $("#totalDiskon").text(disPersen+"% / "+convToRp(disNominal));
    $("#gTotal").text(convToRp(total-disNominal));
    $("#sisa").text(convToRp(total-disNominal));
  }

  function discTotalNominal(total)
  {
    var disNominal = $("#disTotalN").val();
    var disPersen = 0;
    disPersen = (disNominal / total) * 100;
    $("#disTotalP").val(disPersen.toFixed(1));
    $("#totalDiskon").text(disPersen.toFixed(1)+"% / "+convToRp(disNominal));
    $("#gTotal").text(convToRp(total-disNominal));
    $("#sisa").text(convToRp(total-disNominal));
  }

  function bayarProses(total)
  {
    var gTotal = total - $("#disTotalN").val();
    var bayar = $("#bayar").val();
    $("#tBayar").text(convToRp(bayar));
    sisa = gTotal - bayar;
    if(sisa <= 0)
    {
      $("#txtSisa").text("Kembalian");
      sisa = sisa * -1;
      $("#sisa").text(convToRp(sisa));
    } else if(sisa > 0) {
      $("#txtSisa").text("Kurang Bayar");
      $("#sisa").text(convToRp(sisa));
    } else {
      $("#txtSisa").text("Sisa / Kembali");
    }
  }

  document.onkeydown = function(e){
    e = e || window.event;
    keycode = e.which || e.keyCode;
     if(keycode == 112) { //F1
        e.preventDefault();
        // alert("As");
     }
  }
</script> 


@stop