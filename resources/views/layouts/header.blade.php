@php($usaha = App\ProfileUsaha::find(1))
<header class="main-header">
  <a href="{{ url('/') }}" class="logo">
    <span class="logo-mini"><img src="{{ asset('image/') }}/{{ $usaha->image }}" width="40" height="40"></span>
    <span class="logo-lg"><b>{{ $usaha->nama_depan }}</b>{{ $usaha->nama_belakang }}</span>
  </a>
  <nav class="navbar navbar-static-top">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

              <p>
                {{ Auth::user()->name }} - {{ Auth::user()->hak_akses }}
                <small>Member since {{ date('M Y', strtotime(Auth::user()->created_at)) }}</small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>
  </nav>
</header>