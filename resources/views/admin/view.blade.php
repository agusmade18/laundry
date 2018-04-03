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
      <h4><i class="icon fa fa-check"></i> Sukses!</h4>
      {{ Session::get('message') }}
    </div>
    @endif

    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Data Administrator</h3>
          </div>
          
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th width="10">No.</th>
                  <th width="50">Foto</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Hak Akses</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td><img src="{{ asset('image/admin') }}/{{ $user->foto }}" width="50px;"></td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->hak_akses }}</td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i>&nbsp Add Data</button>
            </div>
        </div>
      </div>
    </div>
  </section>
</div>



<div class="modal fade" id="modalAdd">
  <div class="modal-dialog">
    <form action="{{ url('master/admin/save') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><div id="nama">Tambah Data Admin System</div></h4>
      </div>
      <div class="modal-body">
        
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Nama Admin</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="nama" name="nama" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-8">
            <input type="email" class="form-control" id="email" name="email" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Hak Akses</label>
          <div class="col-sm-8">
            <select class="form-control" name="hakAkses" id="hakAkses" required>
              <option value=""> -- Pilih Hak Akses --</option>
              <option value="Admin"> Admin </option>
              <option value="Super Admin"> Super Admin </option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Password</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="pass" name="pass" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Re Password</label>
          <div class="col-sm-8">
            <input type="password" class="form-control" id="repass" name="repass" oninput="matchPass()" required />
          </div>
        </div>
        <div class="form-group">
          <label for="jenis" class="col-sm-3 control-label">Upload Foto</label>
          <div class="col-sm-8">
            <input type="file" accept="image/*" class="form-control" id="image" name="image" required />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="actions btn btn-primary" id="submit">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  function matchPass()
  {
    var pass = $("#pass").val();
    var rePass = $("#repass").val();
    if(pass != rePass)
    {
        $("#submit").prop("disabled",true);
    } else {
       $("#submit").prop("disabled",false);
    }
  }
</script>

@stop