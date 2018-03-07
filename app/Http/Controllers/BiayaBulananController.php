<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\BiayaBulananMaster;
use App\Bulan;
use App\KasBesar;
use App\BiayaBulanan;
use Auth;
use Session;

class BiayaBulananController extends Controller
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
        $bbs = BiayaBulananMaster::all();
        $dateNow = date('m/d/Y', strtotime($this->dateNow));
        return view('biayabulanan.view', compact('bulans', 'month', 'year', 'dateNow', 'bbs'));
    }

    public function search(Request $req)
    {
        return $this->index($req->bulan."/".$req->tahun);
    }

    public function save(Request $req)
    {
        $bBulanan = new BiayaBulanan;
        $bBulanan->id_master = $req->id;
        $bBulanan->nama = $req->nama;
        $bBulanan->keterangan = $req->ket;
        $bBulanan->harga = $req->harga;
        $bBulanan->tanggal = date('Y-m-d', strtotime($req->tgl));
        $bBulanan->add_by = Auth::user()->id;
        $bBulanan->closed = '0';
        $bBulanan->created_at = $this->dateNow;
        $bBulanan->updated_at = $this->dateNow;
        $bBulanan->save();

        $kb = new KasBesar;
        $kb->id_fk = $bBulanan->id;
        $kb->tanggal =  date('Y-m-d', strtotime($req->tgl));
        $kb->harga = $req->harga;
        $kb->qty = '1';
        $kb->debit = '0';
        $kb->kredit = $req->harga;
        $kb->jenis = 'Biaya Bulanan';
        $kb->keterangan = $req->nama;
        $kb->closed = '0';
        $kb->add_by = Auth::user()->id;
        $kb->created_at = $this->dateNow;
        $kb->updated_at = $this->dateNow;
        $kb->save();

        Session::flash('message', 'Data Pengeluaran Berhasil DIsimpan');
        return redirect('biaya-bulanan/bb/now');
    }

    public function update(Request $req)
    {
        $bBulanan = BiayaBulanan::find($req->edId);
        $bBulanan->nama = $req->edNama;
        $bBulanan->keterangan = $req->edKet;
        $bBulanan->harga = $req->edHarga;
        $bBulanan->tanggal = date('Y-m-d', strtotime($req->edTgl));
        $bBulanan->add_by = Auth::user()->id;
        $bBulanan->closed = '0';
        $bBulanan->created_at = $this->dateNow;
        $bBulanan->updated_at = $this->dateNow;
        $bBulanan->save();

        $kb = KasBesar::where('jenis', '=', 'Biaya Bulanan')->where('id_fk', '=', $req->edId)->first();
        $kb->tanggal =  date('Y-m-d', strtotime($req->edTgl));
        $kb->harga = $req->edHarga;
        $kb->qty = '1';
        $kb->debit = '0';
        $kb->kredit = $req->edHarga;
        $kb->jenis = 'Biaya Bulanan';
        $kb->keterangan = $req->edNama;
        $kb->closed = '0';
        $kb->add_by = Auth::user()->id;
        $kb->created_at = $this->dateNow;
        $kb->updated_at = $this->dateNow;
        $kb->save();

        Session::flash('message', 'Data Pengeluaran Berhasil DiUpdate');
        return redirect('biaya-bulanan/bb/now');
    }
}
