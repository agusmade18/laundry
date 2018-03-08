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
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Data Usaha</h3>
          </div>
          <form role="form" action="{{ url('setting-save') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="namaDepan">Nama Depan</label>
                    <input type="text" class="form-control" id="namaDepan" name="namaDepan" placeholder="Nama Depan Usaha Anda" value="{{ $profile->nama_depan }}" required>
                  </div>
                  <div class="col-md-6">
                    <label for="namaBelakang">Nama Belakang</label>
                    <input type="text" class="form-control" id="namaBelakang" name="namaBelakang" placeholder="Nama Belakang Usaha Anda" value="{{ $profile->nama_belakang }}" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat Usaha" value="{{ $profile->alamat }}"  required>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <label for="phone">No. Telp.</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="No. Telephone" value="{{ $profile->phone }}"  required>
                  </div>
                  <div class="col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ $profile->email }}"  required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="jam">Jam Operasional</label>
                <input type="text" class="form-control" id="jam" name="jam" placeholder="Jam Operasional" value="{{ $profile->jam_opr }}"  required>
              </div>

              <div class="form-group">
                <label for="image">Upload Logo Usaha</label><br>
                <img src="{{ asset('image/') }}/{{ $profile->image }}" width="100" height="100" style="margin-bottom: 10px;">
                <input type="file" accept="image/*" name="image" id="image">
                <input type="hidden" name="txtImage" id="txtImage" value="{{ $profile->image }}">
                <p class="help-block">Disarankan ukuran 500px x 500px. Max size 1MB</p>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@stop