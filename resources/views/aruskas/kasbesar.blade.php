@extends('layouts.index')
@section('content')

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Arus Kas
      <small>Kas Kecil</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Arus Kas</a></li>
      <li class="active">Kas Besar</li><li class="active">View</li>
    </ol>
  </section>
  
  <section class="content">
    <div class="row" style="padding: 1px;">
      <div class="col-md-6">
        <h3><strong>Laporan Kas Besar</strong></h3>
      </div>
      <form action="{{ url('aruskas/kasbesar/search') }}" method="GET">
      <div class="col-md-2">
        <label class="control-label">Jenis Akun</label>
        <div class="form-group">
          <select class="form-control" name="jenis" id="jenis">
            <option value="All" {{ $jenis == 'All' ? 'selected' : '' }}>All</option>
            <option value="Pendapatan Jasa" {{ $jenis == 'Pendapatan Jasa' ? 'selected' : '' }}>Pendapatan Jasa</option>
            <option value="Kas Kecil" {{ $jenis == 'Kas Kecil' ? 'selected' : '' }}>Kas Kecil</option>
            <option value="Pengeluaran Kas Besar" {{ $jenis == 'Pengeluaran Kas Besar' ? 'selected' : '' }}>Pengeluaran Kas Besar</option>
            <option value="Restok Barang" {{ $jenis == 'Restok Barang' ? 'selected' : '' }}>Restok Barang</option>
            <option value="Other Income" {{ $jenis == 'Other Income' ? 'selected' : '' }}>Other Income</option>
            <option value="Penjualan" {{ $jenis == 'Penjualan' ? 'selected' : '' }}>Penjualan</option>
            <option value="Biaya Bulanan" {{ $jenis == 'Biaya Bulanan' ? 'selected' : '' }}>Biaya Bulanan</option>
            <option value="Beban Bulanan" {{ $jenis == 'Gaji' ? 'selected' : '' }}>Gaji</option>
          </select>
        </div>
      </div>
      <div class="col-md-3">
        <label class="control-label">Tanggal</label>
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
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
        <form method="post" action="{{ url('aruskas/kasbesar/multipleDelete') }}">
        {{ csrf_field() }}
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th><i class="fa-resize-vertical"></i></th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Hrg/Qty</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Tanggal</th>
            <th>Admin</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @foreach($kbs as $kb)
          <tr>
            <td><input type="checkbox" name="id[]" value="{{ $kb->id }}" /></td>
            <td>{{ $kb->jenis }}</td>
            <td>{{ $kb->keterangan }}</td>
            <td>{{ number_format($kb->harga) }}/{{ $kb->qty }}</td>
            <td>{{ number_format($kb->debit) }}</td>
            <td>{{ number_format($kb->kredit) }}</td>
            <td>{{ date('d M Y', strtotime($kb->tanggal)) }}</td>
            <td>{{ $kb->admin->name }}</td>
            <td>{{ $kb->closed }}</td>
            <td>
              <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#modalEdit" onclick="editData('{{ $kb->id }}', '{{ $kb->tanggal }}', '{{ $kb->harga }}', '{{ $kb->qty }}', '{{ $kb->debit }}', '{{ $kb->kredit }}', '{{ $kb->jenis }}', '{{ $kb->keterangan }}')"><i class="fa fa-pencil"></i></button>
              <a onclick="return confirm('Hapus Kas Besar Ini?');" href="{{ url('aruskas/kasbesarDelete/'.$kb->id) }}">
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
          <div class="col-md-1">
            <button type="submit" name="batal" value="batal" class="btn btn-danger" onclick="return confirm('Hapus Semua Pengeluaran ini?')"><i class="fa fa-remove">&nbsp Hapus</i></button>
          </div>
        </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            Data Laporan
          </div>
          <div class="box-body">
            <table class="table table-bordered">
              <tr>
                <td>Pendapatan Jasa</td>
                <td>Rp {{ number_format($pj) }}</td>
              </tr>
              <tr>
                <td>Penjualan</td>
                <td>Rp {{ number_format($pn) }}</td>
              </tr>
              <tr>
                <td>Other Income</td>
                <td>Rp {{ number_format($oi) }}</td>
              </tr>
              <tr>
                <td>Kas Kecil</td>
                <td>Rp {{ number_format($kc) }}</td>
              </tr>
              <tr>
                <td>Pengeluaran Kas Besar</td>
                <td>Rp {{ number_format($ks) }}</td>
              </tr>
              <tr>
                <td>Re-Stok Barang</td>
                <td>Rp {{ number_format($rb) }}</td>
              </tr>
              <tr>
                <td>Beban Bulanan</td>
                <td>Rp {{ number_format($bb) }}</td>
              </tr>
              <tr>
                <td>Gaji</td>
                <td>Rp {{ number_format($gj) }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            Data Laporan
          </div>
          <div class="box-body">
            <table class="table table-bordered" style="font-size: 1.5em; font-weight: bold;">
              <tr>
                <td>Pemasukan</td>
                <td>Rp {{ number_format($pemasukan) }}</td>
              </tr>
              <tr>
                <td>Pengeluaran</td>
                <td>Rp {{ number_format($pengeluaran) }}</td>
              </tr>
              <tr>
                <td>Total Pendapatan Bersih</td>
                <td>Rp {{ number_format($pemasukan - $pengeluaran) }}</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>


{{-- MODAL ADD--}}
<div class="modal fade" id="modalAdd">
  <div class="modal-dialog">
    <form action="{{ url('aruskas/kasBesarSave') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data ke Kas Besar</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="keterangan" name="keterangan" required/>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Jenis Akun</label>
          <div class="col-sm-6">
            <select name="jnsAkun" id="jnsAkun" class="form-control" required>
              <option value="">--- Pilih Jenis Akun---</option>
              <option value="Pendapatan Jasa">Pendapatan Jasa</option>
              <option value="Kas Kecil">Kas Kecil</option>
              <option value="Pengeluaran Kas Besar">Pengeluaran Kas Besar</option>
              <option value="Restok Barang">Restok Barang</option>
              <option value="Other Income">Other Income</option>
              <option value="Penjualan">Penjualan</option>
              <option value="Beban Bulanan">Beban Bulanan</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-6">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" value="{{ $dateNow }}" id="datepicker" name="tanggal" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Arus kas</label>
          <div class="col-sm-6">
            <input type="radio" name="dk" id="dk" value="debit" required> Debit (Uang Masuk)
            <input type="radio" name="dk" id="dk" value="kredit" required> Kredit (Uang Keluar)
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
            <input type="number" min="1" value="1" class="form-control" id="qty" name="qty" oninput="getTotal()" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="total" name="total" value="Rp 0" disabled />
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
    <form action="{{ url('aruskas/kasBesarUpdate') }}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Edit Data Kas Besar</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="edKeterangan" name="edKeterangan" required/>
            <input type="hidden" id="id" name="id" />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Jenis Akun</label>
          <div class="col-sm-6">
            <select name="edJnsAkun" id="edJnsAkun" class="form-control" required>
              <option value="">--- Pilih Jenis Akun---</option>
              <option value="Pendapatan Jasa">Pendapatan Jasa</option>
              <option value="Kas Kecil">Kas Kecil</option>
              <option value="Pengeluaran Kas Besar">Pengeluaran Kas Besar</option>
              <option value="Restok Barang">Restok Barang</option>
              <option value="Other Income">Other Income</option>
              <option value="Penjualan">Penjualan</option>
              <option value="Beban Bulanan">Beban Bulanan</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Tanggal</label>
          <div class="col-sm-6">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" value="{{ $dateNow }}" id="datepicker2" name="edTanggal" required>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Arus kas</label>
          <div class="col-sm-6">
            <input type="radio" name="edDk" id="edDb" value="debit" required> Debit (Uang Masuk)
            <input type="radio" name="edDk" id="edKr" value="kredit" required> Kredit (Uang Keluar)
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
            <input type="number" min="1" value="1" class="form-control" id="edQty" name="edQty" oninput="edGetTotal()" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Total</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" id="edTotal" name="edTotal" value="Rp 0" disabled />
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

</script>

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

  function editData(id, tgl, hrg, qty, db, kr, jns, ket)
  {
    if(db == 0)
    {
      $("#edKr").attr('checked', 'checked');
    } else {
      $("#edDb").attr('checked', 'checked');
    }
    $("#id").val(id);
    $("#edKeterangan").val(ket);
    $("#edJnsAkun").val(jns);
    $("#edTanggal").val(tgl);
    $("#edHarga").val(hrg);
    $("#edQty").val(qty);
    $("#edTotal").val(convToRp(hrg*qty));
  }
</script>
@stop
