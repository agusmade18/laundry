<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LaundryHeader;
use Carbon\Carbon;
use Auth;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $serialKey = shell_exec('wmic diskdrive get serialnumber');
        //     $serialKey = preg_replace('/\s+/', '', $serialKey);
        // dd(bcrypt($serialKey));
        $lTgl = new Carbon('last day of this month');
        $tgl = $lTgl->day;

        $pro = LaundryHeader::where('status', '=', 'Proses')->get();
        $del = LaundryHeader::where('status', '=', 'delete')->get();
        $don = LaundryHeader::where('status', '=', 'done')->get();
        return view('home', compact('pro', 'del', 'don', 'tgl'));
    }

    public function getLogout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function getLength()
    {
        $lTgl = new Carbon('last day of this month');
        $length = $lTgl->day;
        $tgl = [];
        for($i=1;$i<=$length;$i++)
        {
            $tgl[] = $i;
        }
        //$tgl = LaundryHeader::all();
        echo json_encode($tgl);
    }
}
