<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Gaji;
use App\User;
use App\Bulan;
use App\KasBesar;
use Auth;
use Session;

class GajiController extends Controller
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
        $users = User::all();
        $dateNow = date('m/d/Y', strtotime($this->dateNow));
        $gajis = Gaji::whereMonth('tanggal', '=', $month)->whereYear('tanggal', '=', $year)->get();
    	return view('gaji.view', compact('bulans', 'month', 'year', 'gajis', 'users', 'dateNow'));
    }

    public function search(Request $req)
    {   
        $param = $req->bulan."/".$req->tahun;
        return $this->index($param);
    }

    public function save(Request $req)
    {
        $getMonth =  explode('/', $req->tgl);
        $cekGaji = Gaji::whereMonth('tanggal', '=', $getMonth[0])
        ->where('id_admin', '=', $req->admin)->get();
        if(count($cekGaji)>0)
        {
            Session::flash('error', 'Data Gaji Sudah Ada');
        } else {
            $gPokok = $this->clearRp($req->gPokok);
            $bonus = $this->clearRp($req->bonus);
            $potongan = $this->clearRp($req->potongan);
            $total =  $gPokok + $bonus - $potongan;
            $gaji = new Gaji;
            $gaji->id_admin = $req->admin;
            $gaji->gaji_pokok = $gPokok;
            $gaji->tambahan = $bonus;
            $gaji->potongan = $potongan;
            $gaji->total = $total;
            $gaji->ket_tambahan = $req->ketBonus;
            $gaji->ket_potongan = $req->ketPotongan;
            $gaji->add_by = Auth::user()->id;
            $gaji->tanggal = date('Y-m-d', strtotime($req->tgl));
            $gaji->closed = '0';
            $gaji->created_at = $this->dateNow;
            $gaji->updated_at = $this->dateNow;
            $gaji->save();

            $kb = new KasBesar;
            $kb->id_fk = $gaji->id;
            $kb->tanggal =  date('Y-m-d', strtotime($req->tgl));
            $kb->harga = $total;
            $kb->qty = '1';
            $kb->debit = '0';
            $kb->kredit = $total;
            $kb->jenis = 'Gaji';
            $kb->keterangan = 'Gaji '.$req->namaadm;
            $kb->closed = '0';
            $kb->add_by = Auth::user()->id;
            $kb->created_at = $this->dateNow;
            $kb->updated_at = $this->dateNow;
            $kb->save();

            Session::flash('message', 'Data Gaji Berhasil Ditambahkan..');
        }
        return redirect('biaya-bulanan/gaji/now');
    }

    public function clearRp($str)
    {
        $hasil = str_replace("Rp ","",$str);
        $hasil = str_replace(".","",$hasil);
        return $hasil;
    }

    public function delete($id)
    {
        $gaji = Gaji::find($id);
        $gaji->delete();

        $kb = KasBesar::where('jenis', '=', 'Gaji')
        ->where('id_fk', '=', $id)->first();
        $kb->delete();

        Session::flash('message', 'Data Gaji Berhasil Dihapus');
        return redirect('biaya-bulanan/gaji/now');
    }
}
