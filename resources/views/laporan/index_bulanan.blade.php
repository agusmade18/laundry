@extends('layouts.index')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Laporan
      <small>Bulanan</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content"> 
    <div class="row">

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

      <section class="col-lg-12 connectedSortable">
        <div class="box box-primary">
          <div class="box-header">
            <form action="{{ url('laporan/bulanan-search') }}" method="get">
              <div class="row">
                <div class="col-md-8">
                  <h4><strong>Data Jasa Laundry Bulan {{ $nmBln->nama." Tahun ".$year }}</strong></h4>
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
          <div class="box-body chat" id="chat-box">
            <div style="width: 80%">
              <canvas id="canvas" height="200" width="600"></canvas>
            </div>
          </div>
          <div class="box-footer">

          </div>
        </div>
      </section>
    </div>

  </section>
</div>


<script>

function chart()
{
  $.ajax({
    type : "get",
    url  : "{{ url('getLaporanBulanan') }}",
    dataType : "json",
    error: function(data){
      alert(JSON.stringify(data));
    },
    success : function(data){

      var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
      var barChartData = {
        labels : [],
        datasets : [
          {
            fillColor : "rgba(151,187,205,0.5)",
            strokeColor : "rgba(151,187,205,0.8)",
            highlightFill : "rgba(151,187,205,0.75)",
            highlightStroke : "rgba(151,187,205,1)",
            data : []
          }
        ]

      }

      data.bulan.forEach(function(e){
        barChartData.labels.push(e.nama);
      });

      data.nominal.forEach(function(e){
        barChartData.datasets[0].data.push(e);
      });

      var ctx = document.getElementById("canvas").getContext("2d");
      window.myBar = new Chart(ctx).Bar(barChartData, {
        responsive : true
      });

    } 
  });
}

window.onload = function(){
  chart(); 
}

</script>
@stop