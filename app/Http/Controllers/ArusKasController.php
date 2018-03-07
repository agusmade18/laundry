<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KasBesar;
use App\KasKecil;
use App\KasKecilArus;
use Carbon\Carbon;
use Session;
use Auth;
use Datetime;

class ArusKasController extends Controller
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


	public function indexKasKecilRincian()
	{
    $dateNow = Carbon::now()->toDateString();
    $dateNow = date('m/d/Y', strtotime($dateNow));
		$kks = KasKecilArus::where('status', '=', '0')->get();
		return view('aruskas.kaskecilrincian', compact('kks', 'dateNow'));
	}

  public function indexKasKecil($kode)
  {
    $kasRs = KasKecilArus::where('kode', '=', $kode)->get();
    $kks = KasKecil::all();
    return view('aruskas.kaskecil', compact('kks', 'kasRs'));
  }

  public function kasKecilCari(Request $req)
  {
    $cari = $req->q;
    $kasRs = KasKecilArus::where('nama', 'LIKE', "%".$cari."%")->get();
    //dd($kasRs);
    $kks = KasKecil::all();
    return view('aruskas.kaskecilresult', compact('kks', 'kasRs', 'cari'));
  }

  public function kaskecilSave(Request $req)
  {
    $kode = $this->getKode();
    $kks = new KasKecilArus;
    $kks->kode = $kode;
    $kks->nama = $req->nama;
    $kks->tanggal = date('Y-m-d', strtotime($req->tgl));
    $kks->harga = $req->harga;
    $kks->qty = $req->qty;
    $kks->total = $req->qty * $req->harga;
    $kks->keterangan = $req->ket;
    $kks->status = '0';
    $kks->closed = '0';
    $kks->add_by = Auth::user()->id;
    $kks->created_at = $this->dateNow;
    $kks->updated_at = $this->dateNow;
    $kks->save();

    Session::flash('message', 'Data Pengeluaran Berhasil Ditambahkan');
    return redirect('aruskas/kaskecilrincian');
  }

  public function getKode()
  {
    $kb = KasKecil::all();
    $jum = count($kb);
    if($jum == 0)
    {
      $jum = sprintf("%04d", "1");
    } else {
      $jum = sprintf("%04d", $jum+1);
    }
    return "KSC-".$jum;
  }

  public function kaskecilUpdate(Request $req)
  {
    $kks = KasKecilArus::find($req->id);
    $kks->nama = $req->edNama;
    $kks->tanggal =  date('Y-m-d', strtotime($req->edTgl));
    $kks->harga = $req->edHarga;
    $kks->qty = $req->edQty;
    $kks->total = $req->edQty * $req->edHarga;
    $kks->keterangan = $req->edKet;
    $kks->add_by = Auth::user()->id;
    $kks->created_at = $this->dateNow;
    $kks->updated_at = $this->dateNow;
    $kks->save();

    Session::flash('message', 'Data Pengeluaran Berhasil Diupdate');
    return redirect('aruskas/kaskecilrincian');
  }

  public function delete($id)
  {
    $kks = KasKecilArus::find($id);
    if($kks)
    {
      $kks->delete();
      Session::flash('message', 'Data Pengeluaran Berhasil DiHapus');
    } else {
      Session::flash('error', 'Data Pengeluaran Gagal DiHapus');
    }
    return redirect('aruskas/kaskecilrincian');
  }

  public function multipleDelete(Request $req)
  {
    $jum = count($req->id);
    if($jum)
    {
      for($i=0;$i<$jum;$i++)
      {
        $kks = KasKecilArus::find($req->id[$i]);
        $kks->delete();
      }
      Session::flash('message', 'Data Pengeluaran Berhasil DiHapus');
    } else {
      Session::flash('error', 'Empty Data');
    }
    return redirect('aruskas/kaskecilrincian');
  }

  public function export()
  {
    $kka = KasKecilArus::where('status', '=', '0')->get();
    if(count($kka))
    {
      $jum = $kka->sum('total');
      $kode = $kka[0]->kode;

      $updateKka = KasKecilArus::query()->update(['status' => '1']);

      $kk = new KasKecil;
      $kk->nominal = $jum;
      $kk->kode = $kode;
      $kk->tanggal = Carbon::now()->toDateString();
      $kk->status = '0';
      $kk->closed = '0';
      $kk->add_by = Auth::user()->id;
      $kk->created_at = $this->dateNow;
      $kk->updated_at = $this->dateNow;
      $kk->save();

      $kb = new KasBesar;
      $kb->id_fk = $kk->id;
      $kb->tanggal = Carbon::now()->toDateString();
      $kb->harga = $jum;
      $kb->qty = '1';
      $kb->debit = '0';
      $kb->kredit = $jum;
      $kb->jenis = "Kas Kecil";
      $kb->keterangan = $kode;
      $kb->closed = '0';
      $kb->add_by = Auth::user()->id;
      $kb->created_at = $this->dateNow;
      $kb->updated_at = $this->dateNow;
      $kb->save();

      Session::flash('message', 'Kas Kecil Berhasil di export ke Kas Besar');
    } else {
      Session::flash('error', 'Kas Kecil Kosong');
    }
    return redirect('aruskas/kaskecilrincian');
  }

  public function indexKasBesar($date, $jenis)
  {
    $fDate = new Carbon('first day of this month');
    $fDate = $fDate->toDateString();
    $lDate = new Carbon('last day of this month');
    $lDate = $lDate->toDateString();
    $kbs = "";
    if($date == "now" && $jenis == "all")
    {
      $kbs = KasBesar::whereBetween('tanggal', array($fDate, $lDate))->get();
    } else {
      $getDate = explode('-', $date);
      $fDate = date('Y-m-d', strtotime(str_replace(" ", "", $getDate[0])));;
      $lDate = date('Y-m-d', strtotime(str_replace(" ", "", $getDate[1])));;
      if($jenis == "All")
      {
        $kbs = KasBesar::whereBetween('tanggal', array($fDate, $lDate))->get();
      } else {
        $kbs = KasBesar::whereBetween('tanggal', array($fDate, $lDate))->where('jenis', '=', $jenis)->get();
      }
    }
    $myFDate = date('m/d/Y', strtotime($fDate));
    $myLDate = date('m/d/Y', strtotime($lDate));
    $interval = $myFDate." - ".$myLDate;
    $jenis == "" ? 'All' : $jenis = $jenis;
    $dateNow = Carbon::now()->toDateString();
    $dateNow = date('m/d/Y', strtotime($dateNow));

    $pj = $this->getTotalByJenis("Pendapatan Jasa", $fDate, $lDate, "debit");
    $kc = $this->getTotalByJenis("Kas Kecil", $fDate, $lDate, "kredit");
    $ks = $this->getTotalByJenis("Pengeluaran Kas Besar", $fDate, $lDate, "kredit");
    $rb = $this->getTotalByJenis("Restok Barang", $fDate, $lDate, "kredit");
    $oi = $this->getTotalByJenis("Other Income", $fDate, $lDate, "debit");
    $pn = $this->getTotalByJenis("Penjualan", $fDate, $lDate, "debit");
    $bb = $this->getTotalByJenis("Biaya Bulanan", $fDate, $lDate, "kredit");
    $gj = $this->getTotalByJenis("Gaji", $fDate, $lDate, "kredit");

    $pemasukan = $kbs->sum('debit');
    $pengeluaran = $kbs->sum('kredit');

    return view('aruskas.kasbesar', compact('kbs', 'interval', 'jenis', 'dateNow', 'pj', 'kc', 'ks', 'rb', 'oi', 'pn', 'bb', 'gj', 'pemasukan', 'pengeluaran'));
  }

  public function getTotalByJenis($jenis, $fDate, $lDate, $dk)
  {
    $jum = 0;
    $kb = KasBesar::where('jenis', '=', $jenis)->
    whereBetween('tanggal', array($fDate, $lDate))->get();
    $jum = $kb->sum($dk);
    return $jum;
  }

  public function searchKasBesar(Request $req)
  {
    return $this->indexKasBesar($req->tgl, $req->jenis);
  }

  public function kasBesarSave(Request $req)
  {
    $kb = new KasBesar;
    $dk = $req->dk;
    $debit=0;$kredit=0;
    if($dk == "debit")
    {
      $debit = $req->harga * $req->qty;
      $kredit = 0;
    } else {
      $debit = 0;
      $kredit = $req->harga * $req->qty;
    }
    $kb->id_fk = '0';
    $kb->tanggal = date('Y-m-d', strtotime($req->tanggal));
    $kb->harga = $req->harga;
    $kb->qty = $req->qty;
    $kb->debit = $debit;
    $kb->kredit = $kredit;
    $kb->jenis = $req->jnsAkun;
    $kb->keterangan = $req->keterangan;
    $kb->closed = '0';
    $kb->add_by = Auth::user()->id;
    $kb->created_at = $this->dateNow;
    $kb->updated_at = $this->dateNow;
    $kb->save();

    Session::flash('message', 'Data Berhasil Ditambahkan');
    return redirect('aruskas/kasbesar/now/all');
  }

  public function kasBesarUpdate(Request $req)
  {
    $kb = KasBesar::find($req->id);
    $dk = $req->edDk;
    $debit=0;$kredit=0;
    if($dk == "debit")
    {
      $debit = $req->edHarga * $req->edQty;
      $kredit = 0;
    } else {
      $debit = 0;
      $kredit = $req->edHarga * $req->edQty;
    }
    $kb->tanggal = date('Y-m-d', strtotime($req->edTanggal));
    $kb->harga = $req->edHarga;
    $kb->qty = $req->edQty;
    $kb->debit = $debit;
    $kb->kredit = $kredit;
    $kb->jenis = $req->edJnsAkun;
    $kb->keterangan = $req->edKeterangan;
    $kb->add_by = Auth::user()->id;
    $kb->created_at = $this->dateNow;
    $kb->updated_at = $this->dateNow;
    $kb->save();

    Session::flash('message', 'Data Berhasil Diupdate');
    return redirect('aruskas/kasbesar/now/all');
  }

  public function kasbesarDelete($id)
  {
    $kb = KasBesar::find($id);
    $kb->delete();

    Session::flash('message', 'Data Berhasil Dihapus');
    return redirect('aruskas/kasbesar/now/all');
  }

  public function kBsrMultipleDelete(Request $req)
  {
    $jum = count($req->id);
    if($jum)
    {
      for($i=0;$i<$jum;$i++)
      {
        $kb = KasBesar::find($req->id[$i]);
        $kb->delete();
      }
      Session::flash('message', 'Data Pengeluaran Berhasil DiHapus');
    } else {
      Session::flash('error', 'Empty Data');
    }
    return redirect('aruskas/kasbesar/now/all');
  }
}
