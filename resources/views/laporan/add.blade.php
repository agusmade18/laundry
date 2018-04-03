@extends('layouts.index')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Tambah Data Closing Laporan
      <small>Harian</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content"> 
    <div class="row">
      <section class="col-lg-12 connectedSortable">
        <div class="box box-primary">
          <div class="box-header">
            <h4>Closing Harian</h4>
          </div>
          <div class="box-body chat" id="chat-box">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-bordered">
                  <form class="form-horizontal" action="{{ url('laporan/harian-add/') }}" method="GET">
                  <tr>
                    <td width="130">Tanggal Closing</td>
                    <td width="110">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker" name="tgl" value="{{ $dateNow }}">
                      </div>
                    </td>
                    <td width="50" align="right">
                      <button type="submit" class="btn btn-primary" name="cari" id="cari" value="1" style="width: 100%"><i class="fa fa-search"></i></button>
                    </td>
                  </tr>
                  </form>
                  @if(!empty($_GET['cari']))
                  <form class="form-horizontal" action="{{ url('laporan/harian-save/') }}" method="POST">
                    {{ csrf_field() }}
                  <tr>
                    <td width="130">Total Penyelesaian Laundry & Jumlah Transaksi</td>
                    <td width="100">
                      <div class="form-group">
                        <input type="hidden" name="myTgl" id="myTgl" value="{{ date('Y-m-d', strtotime($_GET['tgl'])) }}">
                        <input type="text" name="laundry" id="laundry" class="form-control" value="{{ number_format($lh->sum('grand_total')) }}" readonly>
                      </div>
                    </td>
                    <td width="50">
                      <div class="form-group">
                        <input type="text" min="0" name="jumLaundry" id="jumLaundry" class="form-control" value="{{ number_format($lh->count('id')) }}" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="130">Total Penjualan & Transaksi</td>
                    <td width="100">
                      <div class="form-group">
                        <input type="text" min="0" name="penjualan" id="penjualan" class="form-control" value="{{ number_format($pj->sum('grand_total')) }}" readonly>
                      </div>
                    </td>
                    <td width="50">
                      <div class="form-group">
                        <input type="text" name="jumJual" id="jumJual" value="{{ number_format($pj->count('grand_total')) }}" readonly class="form-control" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="130">Total Laba Penjualan</td>
                    <td width="100" colspan="2">
                      <div class="form-group">
                        <input type="text" name="laba" id="laba" class="form-control" value="{{ number_format($pj->sum('total_laba')) }}" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="130">Total Pengeluaran</td>
                    <td width="100" colspan="2">
                      <div class="form-group">
                        <input type="text" name="pengeluaran" id="pengeluaran" class="form-control" value="{{ number_format($peng->sum('kredit')) }}" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="130">Jml. Fisik Uang</td>
                    <td width="100" colspan="2">
                      <div class="form-group">
                        <input type="text" name="fu" id="fu" class="form-control" value="{{ number_format($uangCash) }}" readonly>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="130">Keterangan</td>
                    <td width="100" colspan="2">
                      <div class="form-group">
                        <input type="text" name="ket" id="ket" class="form-control" placeholder="Keterangan">
                      </div>
                    </td>
                  </tr>
                   <tr>
                    <td colspan="3" align="right"><button type="submit" class="btn btn-primary" name="cari" id="cari" value="1" style="width: 30%"><i class="fa fa-save"></i> &nbspSimpan Data</button></td>
                  </tr>
                  </form>
                  @endif
                </table>
              </div>
            </div>
          </div>
          <div class="box-footer">

          </div>
        </div>
      </section>
    </div>

  </section>
</div>
</script>
@stop