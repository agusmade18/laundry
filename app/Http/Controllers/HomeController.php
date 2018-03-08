<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\LaundryHeader;
use App\LaporanHarian;
use App\PenjualanHeader;
use App\Bulan;
use App\ProfileUsaha;
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
    private $dateNow;
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->dateNow = Carbon::now()->toDateString();
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
        $penj = PenjualanHeader::all();
        return view('home', compact('pro', 'del', 'don', 'tgl', 'penj'));
    }

    public function getLogout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function getData()
    {
        $lTgl = Carbon::now();
        $month = $lTgl->month;
        // $tgl = [];
        // for($i=1;$i<=$length;$i++)
        // {
        //     $tgl[] = $i;
        // }
        //$tgl = LaundryHeader::all();
        $tgl = LaporanHarian::whereMonth('tanggal', '=', $month)->get();
        echo json_encode($tgl);
    }

    public function getDataBulanan()
    {
        $bulan = Bulan::all();
        $value = [];
        for($i=0;$i<12;$i++)
        {
            $value[] = rand(10,100);
        }
        echo json_encode(array('bulan'=>$bulan, 'nominal'=>$value));
    }

    public function setting()
    {
        $profile = ProfileUsaha::find(1);
        return view('setting', compact('profile'));
    }

    public function save(Request $req)
    {
        $imageName = $req->txtImage;
        if(Input::hasFile('image')){
            $imageName  = Input::file('image')->getClientOriginalName();
            $file       = Input::file('image');
            $file       = $file->move(public_path().'/image/', $file->getClientOriginalName());
        }

        $profile = ProfileUsaha::find(1);
        $profile->nama_depan    = $req->namaDepan;
        $profile->nama_belakang    = $req->namaBelakang;
        $profile->alamat    = $req->alamat;
        $profile->phone    = $req->phone;
        $profile->email    = $req->email;
        $profile->jam_opr    = $req->jam;
        $profile->updated_at    = $this->dateNow;
        $profile->admin    = Auth::user()->id;
        $profile->image    = $imageName;
        $profile->save();

        Session::flash('message', 'Data Berhasil Dirubah...');
        return redirect('/setting');
    }
}
