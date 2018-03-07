<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>

      <li class="{{ Request::segment(1) == null  ? 'active' : '' }}"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

      
      <li class="{{ Request::segment(1) == 'laundry' ? 'active' : '' }} treeview">
        <a href="#">
          <i class="fa fa-book"></i> <span>Data Laundry</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
          <span class="pull-right-container">
            <span class="label label-primary pull-right">
            @php($pro = App\LaundryHeader::where('status', '=', 'proses')->get())
            {{ $pro->count('id') }}
            </span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::segment(1) == 'laundry' && Request::segment(2) == 'view' ? 'active' : '' }}"><a href="{{ url('laundry/view') }}"><i class="fa fa-circle-o"></i>Data Proses</a></li>
          <li class="{{ Request::segment(1) == 'laundry' && Request::segment(2) == 'done' ? 'active' : '' }}"><a href="{{ url('laundry/done') }}"><i class="fa fa-circle-o"></i>Data Selesai</a></li>
          <li class="{{ Request::segment(1) == 'laundry' && Request::segment(2) == 'canceledTransaksi' ? 'active' : '' }}"><a href="{{ url('laundry/canceledTransaksi') }}"><i class="fa fa-circle-o"></i>Data Pembatalan</a></li>
        </ul>
      </li>
      

      <li class="{{ Request::segment(1) == 'penjualan' ? 'active' : '' }} treeview">
        <a href="#">
          <i class="fa fa-line-chart"></i> <span>Penjualan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::segment(1) == 'penjualan' && Request::segment(2) == 'transaksi' ? 'active' : '' }}"><a href="{{ url('penjualan/transaksi') }}"><i class="fa fa-circle-o"></i> Tambah Penjualan</a></li>
          <li class="{{ Request::segment(1) == 'penjualan' && Request::segment(2) == 'view' ? 'active' : '' }}"><a href="{{ url('penjualan/view/now') }}"><i class="fa fa-circle-o"></i> Data Penjualan</a></li>
        </ul>
      </li>


      <li class="{{ Request::segment(1) == 'aruskas' ? 'active' : '' }}  treeview">
        <a href="#">
          <i class="fa fa-expand"></i> <span>Arus Kas</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::segment(1) == 'aruskas' && Request::segment(2) == 'kaskecilrincian' ? 'active' : '' }}"><a href="{{ url('aruskas/kaskecilrincian') }}"><i class="fa fa-circle-o"></i> Kas Kecil Rincian</a></li>
          <li class="{{ Request::segment(1) == 'aruskas' && Request::segment(2) == 'kaskecil' ? 'active' : '' }}"><a href="{{ url('aruskas/kaskecil/all') }}"><i class="fa fa-circle-o"></i> Kas Kecil</a></li>
          <li class="{{ Request::segment(2) == 'kasbesar' ? 'active' : '' }}"><a href="{{ url('aruskas/kasbesar/now/all') }}"><i class="fa fa-circle-o"></i> Kas Besar</a></li>
        </ul>
      </li>


      <li class="{{ Request::segment(1) == 'restok' ? 'active' : '' }}"><a href="{{ url('restok/view/now') }}"><i class="fa fa-arrow-down"></i> <span>Re-Stock Barang</span></a></li>


      <li class="{{ Request::segment(1) == 'biaya-bulanan' ? 'active' : '' }} treeview">
        <a href="#">
          <i class="fa fa-dollar"></i> <span>Biaya Bulanan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::segment(1) == 'biaya-bulanan' &&  Request::segment(2) == 'gaji' ? 'active' : '' }}"><a href="{{ url('biaya-bulanan/gaji/now') }}"><i class="fa fa-circle-o"></i> Gaji</a></li>
          <li class="{{ Request::segment(1) == 'biaya-bulanan' &&  Request::segment(2) == 'bb' ? 'active' : '' }}"><a href="{{ url('biaya-bulanan/bb/now') }}"><i class="fa fa-circle-o"></i> Biaya Bulanan</a></li>
        </ul>
      </li>


      <li class="{{ Request::segment(1) == 'other' ? 'active' : '' }} treeview">
        <a href="#">
          <i class="fa fa-paper-plane"></i> <span>Other</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::segment(1) == 'other' && Request::segment(2) == 'kerugian' ? 'active' : '' }}"><a href="{{ url('other/kerugian/now') }}"><i class="fa fa-circle-o"></i> Kerugian</a></li>
          <li class="{{ Request::segment(1) == 'other' && Request::segment(2) == 'other-income' ? 'active' : '' }}"><a href="{{ url('other/other-income/now') }}"><i class="fa fa-circle-o"></i> Other Income</a></li>
        </ul>
      </li>


      <li class="{{ Request::segment(1) == 'master' ? 'active' : '' }}  treeview">
        <a href="">
          <i class="fa fa-users"></i> <span>Master Data</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::segment(1) == 'master' &&  Request::segment(2) == 'laundry' ? 'active' : '' }}"><a href="{{ url('master/laundry') }}"><i class="fa fa-circle-o"></i> Barang Laundry</a></li>
          <li class="{{ Request::segment(1) == 'master' &&  Request::segment(2) == 'penjualan' ? 'active' : '' }}"><a href="{{ url('master/penjualan') }}"><i class="fa fa-circle-o"></i> Barang Jual</a></li>
          <li class="{{ Request::segment(1) == 'master' &&  Request::segment(2) == 'biayabulanan' ? 'active' : '' }}"><a href="{{ url('master/biayabulanan') }}"><i class="fa fa-circle-o"></i> Biaya Bulanan</a></li>
          <li><a href="index2.html"><i class="fa fa-circle-o"></i> Customer</a></li>
          <li><a href="index2.html"><i class="fa fa-circle-o"></i> Admin</a></li>
        </ul>
      </li>
      

      <li class="{{-- active --}} treeview">
        <a href="#">
          <i class="fa fa-paperclip"></i> <span>Laporan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="index2.html"><i class="fa fa-circle-o"></i> Laporan Harian</a></li>
          <li><a href="index2.html"><i class="fa fa-circle-o"></i> Laporan Bulanan</a></li>
        </ul>
      </li>


      <li class="header">ABOUT</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>