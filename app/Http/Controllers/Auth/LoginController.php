<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Secret;
use App\LaundryHeader;
use Session;
use Hash;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function makeCode()
    {
      $lastId = 0;
      if(LaundryHeader::count())
      {
        $lastId = LaundryHeader::orderBy('id', 'desc')->first()->id + 1;
      } else {
        $lastId = 1;
      }
      $lastId = sprintf("%04d", $lastId);
      return $lastId;
    }

    public function __construct()
    {
        $registerSerialNumber = Secret::all();
        if(count($registerSerialNumber))
        {
            $serialKey = shell_exec('wmic diskdrive get serialnumber');
            $serialKey = preg_replace('/\s+/', '', $serialKey);
            $sn = (md5(md5($serialKey)));
            //dd(md5(md5($serialKey)));
            if($registerSerialNumber[0]->key_number != $sn)
            {
                session()->put('key_number', "false");
            } else {
                // $kode = "TRS-".$this->makeCode();
                // session()->put('transaksi', $kode);
                // session()->put('key_number', true);
              $kode = "LND-".$this->makeCode();
              session()->put('transaksi', $kode);
              session()->put('key_number', "true");
              $this->middleware('guest')->except('logout'); 
            }
        }
    }
}
