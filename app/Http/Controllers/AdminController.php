<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Session;
use Auth;
use Hash;
use Datetime;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $dateNow;
    public function __construct()
    {
        $this->middleware('auth');
        $this->dateNow = new Datetime;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

  public function index()
  {
  	$users  = User::all();
  	$i = 1;
  	return view('admin.view', compact('users', 'i'));
  }

  public function save(Request $req)
  {
  	$imageName  = "noimage.jpg";
    if(Input::hasFile('image')){
    	$imageName  = Input::file('image')->getClientOriginalName();
      $file       = Input::file('image');
      $file       = $file->move(public_path().'/image/admin/', $file->getClientOriginalName());
    }
  	$user = new User;
  	$user->name 			= $req->nama;
  	$user->email 			= $req->email;
  	$user->password 	= bcrypt($req->pass);
  	$user->hak_akses 	= $req->hakAkses;
  	$user->foto 			= $imageName;
  	$user->created_at = $this->dateNow;
  	$user->updated_at = $this->dateNow;
  	$user->save();

  	Session::flash('message', 'Data Admin Berhasil Ditambahkan...');
  	return redirect('master/admin');
  }

  public function edit()
  {
    $user = User::find(Auth::user()->id);
    return view('admin.edit', compact('user'));
  }

  public function updateProfile(Request $req)
  {
    $imageName  = $req->txtImage;
    if(Input::hasFile('image')){
      $imageName  = Input::file('image')->getClientOriginalName();
      $file       = Input::file('image');
      $file       = $file->move(public_path().'/image/admin/', $file->getClientOriginalName());
    }
    $user = User::find(Auth::user()->id);
    $user->name       = $req->nama;
    $user->email      = $req->email;
    $user->hak_akses  = $req->hakAkses;
    $user->foto       = $imageName;
    $user->updated_at = $this->dateNow;
    $user->save();

    Session::flash('message', 'Data Admin Berhasil DiUpdate...');
    return redirect('master/admin/editprofile');
  }

  public function updatePassword(Request $req)
  {
    $current_password = Auth::User()->password;
    if(!Hash::check($req->passLama, $current_password))
    {
        Session::flash('error', "Password Lama Tidak Cocok...");
        return redirect('master/admin/editprofile');
    } else {
      $usr = User::find(Auth::user()->id);
      $usr->password = bcrypt($req->pass);
      $usr->save();
      Auth::logout();
      return redirect('/login');
    }
  }
}
