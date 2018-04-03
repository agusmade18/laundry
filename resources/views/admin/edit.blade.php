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
      <li class="active">Edit Profile</li>
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
    <div class="alert alert-error alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> Error!</h4>
      {{ Session::get('error') }}
    </div>
    @endif

    <div class="row">
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ asset('image/admin') }}/{{ $user->foto }}" alt="User profile picture">
            <h3 class="profile-username text-center">{{ $user->name }}</h3>
            <p class="text-muted text-center">{{ $user->hak_akses }}</p>
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
              </li>
            </ul>
            <form action="{{ url('master/admin/updatePassword') }}" method="post" class="form-horizontal">
            {{ csrf_field() }}
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><div id="nama">Rubah Password</div></h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <div class="col-sm-12">
                    <input type="password" class="form-control" id="passLama" name="passLama" placeholder="Password Lama" required />
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password Baru" required />
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <input type="password" class="form-control" id="repass" name="repass" placeholder="Re Password Baru" oninput="matchPass()" required />
                  </div>
                </div>
              </div>
            </div>
            <button class="btn btn-primary btn-block" id="ubahPass" type="submit"> Update Password </button>
            </form>
          </div>
          <!-- /.box-body -->
        </div>
      </div>

      <div class="col-md-8">
        <div class="box box-primary">
          <div class="box-body box-profile">
            <form action="{{ url('master/admin/updateProfile') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><div id="nama">Edit Profile</div></h4>
              </div>
              <div class="modal-body">
                
                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">Nama Admin</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->name }}" required />
                  </div>
                </div>
                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">Email</label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required />
                  </div>
                </div>
                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">Hak Akses</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="hakAkses" id="hakAkses" required>
                      <option value=""> -- Pilih Hak Akses --</option>
                      <option value="Admin" {{ $user->hak_akses == 'Admin' ? 'selected' : '' }}> Admin </option>
                      <option value="Super Admin" {{ $user->hak_akses == 'Super Admin' ? 'selected' : '' }}> Super Admin </option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="jenis" class="col-sm-3 control-label">Upload Foto</label>
                  <div class="col-sm-8">
                    <input type="file" accept="image/*" class="form-control" id="image" name="image" />
                    <input type="hidden" id="txtImage" name="txtImage" value="{{ $user->foto }}" />
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="actions btn btn-primary" id="submit">Update Profile</button>
              </div>
            </div>
            </form>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
  function matchPass()
  {
    var pass = $("#pass").val();
    var rePass = $("#repass").val();
    if(pass != rePass)
    {
        $("#ubahPass").prop("disabled",true);
    } else {
       $("#ubahPass").prop("disabled",false);
    }
  }
</script>

@stop