<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\KasBesar;
use App\BrgJualMaster;
use Auth;
use Session;

class RestokController extends Controller
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
      $this->dateNow = Carbon::now();
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */

  public function index($date)
  {
  	$restok = "";
    $fDate = "";
    $lDate = "";
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
    $restok = KasBesar::where('jenis', '=', 'Restok Barang')
      ->whereBetween('tanggal', array($fDate, $lDate))->get();
    $brgs = BrgJualMaster::all();
    $myFDate = date('m/d/Y', strtotime($fDate));
    $myLDate = date('m/d/Y', strtotime($lDate));
    $interval = $myFDate." - ".$myLDate;
    $dateNow = Carbon::now()->toDateString();
    $dateNow = date('m/d/Y', strtotime($dateNow));
  	return view('restok.view', compact('interval', 'restok', 'brgs', 'dateNow'));
  }

  public function save(Request $req)
  {
    $kb = new KasBesar;
    $kb->id_fk = $req->id;
    $kb->tanggal = date('Y-m-d', strtotime($req->tgl));
    $kb->harga = $req->hBeli;
    $kb->qty = $req->qty;
    $kb->debit = '0';
    $kb->kredit = $req->hBeli*$req->qty;
    $kb->jenis = 'Restok Barang';
    $kb->keterangan = 'Restok '.$req->nmBrg." - ".$req->ket;
    $kb->closed = '0';
    $kb->add_by = Auth::user()->id;
    $kb->created_at = $this->dateNow;
    $kb->updated_at = $this->dateNow;
    $kb->save();

    $hpp = 0;
    $bm = BrgJualMaster::find($req->id);
    $stok = $bm->stok + $req->qty;
    if($bm->stok == 0)
    {
      $hpp = $req->hBeli;
    } else {
      $hpp = ($bm->hpp + $req->hBeli)/2;
    }
    $bm->hpp = $hpp;
    $bm->h_jual = $req->hJual;
    $bm->stok = $stok;
    $bm->save();

    Session::flash('message', 'Data Berhasil Ditambahkan');
    return redirect('restok/view/now');
  }

  public function delete($id)
  {
    $kb = KasBesar::find($id);
    $qty = $kb->qty;

    $bm = BrgJualMaster::find($kb->id_fk);
    $stok = $bm->stok - $qty;
    $bm->stok = $stok;
    $bm->save();
    $kb->delete();

    Session::flash('message', 'Restok Barang Berhasil Dibatalkan');
    return redirect('restok/view/now');
  }
}
