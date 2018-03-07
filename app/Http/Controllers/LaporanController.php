<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Bulan;
use App\DataCash;
use App\PenjualanHeader;
use App\LaundryHeader;
use App\LaporanHarian;
use Auth;
use Session;

class LaporanController extends Controller
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

    public function index($time)
    {
      $bulans = Bulan::all();
      $now = Carbon::now();
      if($time == "now")
      {
          // $month = $month*1;
          $month = $now->format('m');
          $year = $now->format('Y');
      } else {
          $dt = explode('/', $time);
          $month = $dt[0];
          $year = $dt[1];
      }
      $lapHarians = LaporanHarian::whereMonth('tanggal', '=', $month)->whereYear('tanggal', '=', $year)->orderBy('tanggal', 'ASC')->get();
    	return view('laporan.view',compact('bulans', 'month', 'year', 'lapHarians'));
    }

    public function add(Request $req)
    {
    	if($req->tgl == "")
    	{
	    	$dateNow = date('m/d/Y', strtotime($this->dateNow));
	    	return view('laporan.add', compact('dateNow'));
	    } else {
	    	$dateNow = date('m/d/Y', strtotime($req->tgl));
	    	$dc = DataCash::where('tanggal', '=', date('Y-m-d', strtotime($req->tgl)))->get();
	    	$pj = PenjualanHeader::where('tanggal', '=', date('Y-m-d', strtotime($req->tgl)))->get();
	    	$lh = LaundryHeader::where('tgl_masuk', '=', date('Y-m-d', strtotime($req->tgl)))->get();
	    	return view('laporan.add', compact('dateNow', 'dc', 'pj', 'lh'));
	    }
    }

    public function save(Request $req)
    {
    	$cek = LaporanHarian::where('tanggal', '=', $req->myTgl)->get();
    	if(!count($cek))
    	{
	    	$dc = DataCash::where('tanggal', '=', date('Y-m-d', strtotime($req->myTgl)))->get();
	    	$pj = PenjualanHeader::where('tanggal', '=', date('Y-m-d', strtotime($req->myTgl)))->get();
	    	$lh = LaundryHeader::where('tgl_masuk', '=', date('Y-m-d', strtotime($req->myTgl)))->get();

	    	$lapH = new LaporanHarian;
	    	$lapH->tanggal = $req->myTgl;
	    	$lapH->jum_laundry = $lh->count('id');
	    	$lapH->total_laundry = $lh->sum('grand_total');
	    	$lapH->jum_penjualan = $pj->count('id');
	    	$lapH->tot_penjualan = $pj->sum('grand_total');
	    	$lapH->laba_penjualan = $pj->sum('total_laba');
	    	$lapH->fisik_uang = $dc->sum('nominal');
	    	$lapH->keterangan = $req->ket;
	    	$lapH->add_by = Auth::user()->id;
	    	$lapH->created_at = $this->dateNow;
	    	$lapH->updated_at = $this->dateNow;
				$lapH->save();

				Session::flash('message', 'Data Berhasil Diclosing....');
    	} else {
    		Session::flash('error', 'Data Sudah Ada....');
    	}

    	return redirect('laporan/harian/now');
    }

    public function search(Request $req)
    {
    	$param = $req->bulan."/".$req->tahun;
      return $this->index($param);
    }
}
