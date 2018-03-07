<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Other;
use App\KasBesar;
use Auth;
use Session;

class OtherController extends Controller
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

	public function index($jenis, $date)
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
    $dateNow = Carbon::now()->toDateString();
    $dateNow = date('m/d/Y', strtotime($dateNow));
    $title = "";
    if($jenis == "kerugian")
    {
      $clause = 0;
    } else if($jenis == "other-income") {
      $clause = 1;
    }
    $ots = Other::where('jenis', '=', $clause)->whereBetween('tanggal', array($fDate, $lDate))->get();
  	return view('other.view', compact('interval', 'ots', 'dateNow', 'title'));
  }

  public function search(Request $req)
  {
    return $this->index($req->jenis, $req->tgl);
  }

  public function save(Request $req)
  {
    $ot = new Other;
    $ot->nama = $req->ket;
    $ot->qty = $req->qty;
    $ot->harga = $req->harga;
    $ot->total = $req->qty * $req->harga;
    $ot->tanggal = date('Y-m-d', strtotime($req->tgl));
    $ot->add_by = Auth::user()->id;
    $ot->jenis = $req->jenis;
    $ot->closed = '0';
    $ot->created_at = $this->dateNow;
    $ot->updated_at = $this->dateNow;
    $ot->save();

    if($req->jenis == "0")
    {
      $debit = '0';
      $kredit = $req->qty * $req->harga;
      $jenis = "Kerugian";
      $url = "other/kerugian/now";
    } else {
      $debit = $req->qty * $req->harga;
      $kredit = '0';
      $jenis = "Other Income";
      $url = "other/other-income/now";
    }

    $kb = new KasBesar;
    $kb->id_fk = $ot->id;
    $kb->tanggal =  date('Y-m-d', strtotime($req->tgl));
    $kb->harga = $req->harga;
    $kb->qty = $req->qty;
    $kb->debit = $debit;
    $kb->kredit = $kredit;
    $kb->jenis = $jenis;
    $kb->keterangan = $req->ket;
    $kb->closed = '0';
    $kb->add_by = Auth::user()->id;
    $kb->created_at = $this->dateNow;
    $kb->updated_at = $this->dateNow;
    $kb->save();

    Session::flash('message', 'Data '.$jenis.' Berhasil Ditambahkan');
    return redirect($url);
  }

  public function update(Request $req)
  {
    $ot = Other::find($req->id);
    $ot->nama = $req->edKet;
    $ot->qty = $req->edQty;
    $ot->harga = $req->edHarga;
    $ot->total = $req->edQty * $req->edHarga;
    $ot->tanggal = date('Y-m-d', strtotime($req->edTgl));
    $ot->add_by = Auth::user()->id;
    $ot->jenis = $req->edJenis;
    $ot->closed = '0';
    $ot->created_at = $this->dateNow;
    $ot->updated_at = $this->dateNow;
    $ot->save();

    if($req->edJenis == "0")
    {
      $debit = '0';
      $kredit = $req->edQty * $req->edHarga;
      $jenis = "Kerugian";
      $url = "other/kerugian/now";
    } else {
      $debit = $req->edQty * $req->edHarga;
      $kredit = '0';
      $jenis = "Other Income";
      $url = "other/other-income/now";
    }

    $kb = KasBesar::where('id_fk', '=', $req->id)->where('jenis', '=', $jenis)->first();
    $kb->tanggal =  date('Y-m-d', strtotime($req->edTgl));
    $kb->harga = $req->edHarga;
    $kb->qty = $req->edQty;
    $kb->debit = $debit;
    $kb->kredit = $kredit;
    $kb->jenis = $jenis;
    $kb->keterangan = $req->edKet;
    $kb->closed = '0';
    $kb->add_by = Auth::user()->id;
    $kb->created_at = $this->dateNow;
    $kb->updated_at = $this->dateNow;
    $kb->save();

    Session::flash('message', 'Data '.$jenis.' Berhasil DiUpdate');
    return redirect($url);
  }

  public function delete($id)
  {
    $ot = Other::find($id);
    if($ot->jenis == "0")
    {
      $url = "other/kerugian/now";
      $jenis = "Kerugian";
    } else {
      $url = "other/other-income/now";
      $jenis = "Other Income";
    }
    $ot->delete();

    $kb = KasBesar::where('id_fk', '=', $id)->where('jenis', '=', $jenis)->first();
    $kb->delete();
    Session::flash('message', 'Data '.$jenis.' Berhasil DiHapus');
    return redirect($url);
  }

}
