<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\PenjualanHeader;
use App\PenjualanDetail;
use App\BrgJualMaster;
use App\KasBesar;
use Datetime;
use Auth;
use Session;

class PenjualanController extends Controller
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
    $penjualan = "";
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
    $penjualan = PenjualanHeader::whereBetween('tanggal', array($fDate, $lDate))->get();
    $myFDate = date('m/d/Y', strtotime($fDate));
    $myLDate = date('m/d/Y', strtotime($lDate));
    $interval = $myFDate." - ".$myLDate;
  	return view('penjualan.view', compact('interval', 'penjualan'));
  }

  public function makeCode()
  {
    $lastId = 0;
    if(PenjualanHeader::count())
    {
      $lastId = PenjualanHeader::orderBy('id', 'desc')->first()->id + 1;
    } else {
      $lastId = 1;
    }
    $lastId = sprintf("%04d", $lastId);
    return $lastId;
  }

  public function transaksi()
  {
    $kode = session()->get('penjualan');
    if($kode == "")
    {
      $kode = "PNJ-".$this->makeCode();
      session()->put('penjualan', $kode);
    }
    $pjDetails = PenjualanDetail::where('kode', '=', $kode)->get();
  	$brgs = BrgJualMaster::all();
    $dateNow = Carbon::now()->toDateString();
    $dateNow = date('m/d/Y', strtotime($dateNow));
  	return view('penjualan.transaksi', compact('brgs', 'pjDetails', 'dateNow'));
  }

  public function saveDetail(Request $req)
  {
    $pd = new PenjualanDetail;
    $brgMaster = BrgJualMaster::find($req->id);
    $hpp = $brgMaster->hpp;
    $hJual = $brgMaster->h_jual;

    $pd->kode = session()->get('penjualan');
    $pd->id_brgjual = $req->id;
    $pd->qty = $req->qty;
    $pd->harga = $req->harga;
    $pd->total = $req->harga * $req->qty;
    $pd->diskon_persen = $req->disP;
    $pd->diskon_nominal = $req->disN;
    $pd->grand_total = ($req->harga * $req->qty) - $req->disN;
    $pd->keuntungan = (($hJual-$hpp) * $req->qty) - $req->disN;
    $pd->add_by = Auth::user()->id;
    $pd->status = '0';
    $pd->closed = '0';
    $pd->created_at = $this->dateNow;
    $pd->updated_at = $this->dateNow;
    $pd->save();

    return redirect('penjualan/transaksi');
  }

  public function deletedetail($id)
  {
    $pj = PenjualanDetail::find($id);
    $pj->delete();
    return redirect('penjualan/transaksi');
  }

  public function saveHeader(Request $req)
  {
    $pd = PenjualanDetail::where('kode', '=', session()->get('penjualan'))->get();
    $gTotal = $pd->sum('grand_total') - $req->disTotN;
    if($gTotal > $req->bayar)
    {
      Session::flash('error', 'Pembayaran Kurang');
    } else {
      $ph = new PenjualanHeader;
      $ph->kode = session()->get('penjualan');
      $ph->total = $pd->sum('total');
      $ph->diskon_persen = $req->disTotP;
      $ph->diskon_nominal = $req->disTotN;
      $ph->grand_total = $gTotal;
      $ph->bayar = $req->bayar;
      $ph->total_laba = $pd->sum('keuntungan');
      $ph->tanggal = date('Y-m-d', strtotime($req->tgl));
      $ph->add_by = Auth::user()->id;
      $ph->closed = '0';
      $ph->created_at = $this->dateNow;
      $ph->updated_at = $this->dateNow;
      $ph->save();

      $kb = new KasBesar;
      $kb->id_fk      = $ph->id;
      $kb->tanggal    = date('Y-m-d', strtotime($req->tgl));
      $kb->harga      = $pd->sum('total');
      $kb->qty        = "1";
      $kb->debit      = $pd->sum('total');
      $kb->kredit     = '0';
      $kb->jenis      = 'Penjualan';
      $kb->keterangan = session()->get('penjualan');
      $kb->closed     = '0';
      $kb->add_by     = Auth::user()->id;
      $kb->created_at = $this->dateNow;
      $kb->updated_at = $this->dateNow;
      $kb->save();

      //KURANGI STOK PADA TABLE MASTER BARANG
      for($i=0;$i<count($pd);$i++)
      {
        $brg = BrgJualMaster::find($pd[$i]->barang->id);
        $brg->stok = $pd[$i]->barang->stok - $pd[$i]->qty;
        $brg->save();
      }

      session()->forget('penjualan');
      $kode = "PNJ-".$this->makeCode();
      session()->put('penjualan', $kode);

      Session::flash('message', 'Data Penjualan Berhasil Disimpan');
    }
    return redirect('penjualan/transaksi');
  }

  public function search(Request $req)
  {
    return $this->index($req->tgl);
  }

  public function detail($kode)
  {

  }
  
}
