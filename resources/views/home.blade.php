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

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $pro->count('id') }}</h3>

            <p>Transaksi Baru</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="{{ url('laundry/view') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ $don->count('id') }}</h3>

            <p>Transaksi Selesai</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="{{ url('laundry/done') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ $del->count('id') }}</h3>

            <p>Transaksi Dibatalkan</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="{{ url('laundry/canceledTransaksi') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>65</h3>

            <p>Transaksi Penjualan</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    

    <div class="row">
      <section class="col-lg-12 connectedSortable">
        <div class="box box-success">
          <div class="box-header">
            Grafik Jasa Laundry Harian
          </div>
          <div class="box-body chat" id="chat-box">
            <div>
              <canvas id="canvas" height="50"></canvas>
            </div>
          </div>
          <div class="box-footer">
            Footer
          </div>
        </div>
      </section>

      <section class="col-lg-5 connectedSortable">

      </section>
    </div>

  </section>
</div>

<script>
  function chart()
  {  
    //FUNGSI AJAX
    $.ajax({
      type:"get",
      url:"{{ url('getlengthday') }}",
      dataType:"json",
      error:function(data){
        alert(JSON.stringify(data));
      },
      success:function(data){
        var lineChartData = {
          labels : [],
          datasets : [
            {
              label: "My Second dataset",
              fillColor : "rgba(151,187,205,0.2)",
              strokeColor : "rgba(151,187,205,1)",
              pointColor : "rgba(151,187,205,1)",
              pointStrokeColor : "#fff",
              pointHighlightFill : "#fff",
              pointHighlightStroke : "rgba(151,187,205,1)",
              data : [50,90,52,22,44,88]
            }
          ]
        }
    //===================================================
        data.forEach(function(e)
        {
          lineChartData.labels.push(e);
        });
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx).Line(lineChartData, {
          responsive: true
        });
      }

    });
  }

window.onload = function(){
  chart();
}


</script>
@stop