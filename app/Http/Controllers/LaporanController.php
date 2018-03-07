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

  public function index($date)
  {
    if($date == "now")
    {
      $fDate = new Carbon('first day of this month');
      $fDate = $fDate->toDateString();
      $lDate = new Carbon('last day of this month');
      $lDate = $lDate->toDateString();
    } else {
      $getDate = explode('-', $date);
      $fDate = date('Y-m-d', strtotime(str_replace(" ", "", $getDate[0])));;
      $lDate = date('Y-m-d', strtotime(str_replace(" ", "", $getDate[1])));;
    }
    $myFDate = date('m/d/Y', strtotime($fDate));
    $myLDate = date('m/d/Y', strtotime($lDate));
    $interval = $myFDate." - ".$myLDate;
    $lapHarians = LaporanHarian::whereBetween('tanggal', array($fDate, $lDate))->orderBy('tanggal', 'ASC')->get();
  	return view('laporan.view',compact('interval','lapHarians', 'myFDate', 'myLDate'));
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
    return $this->index($req->tgl);
  }

  public function indexBulanan($time)
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
    $nmBln = Bulan::find($month);
    $dateNow = date('m/d/Y', strtotime($this->dateNow));
    return view('laporan.index_bulanan', compact('bulans', 'month', 'year', 'dateNow', 'nmBln'));
  }

  public function search_bulanan(Request $req)
  {
    $param = $req->bulan."/".$req->tahun;
    return $this->indexBulanan($param);
  }
}
