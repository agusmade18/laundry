<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BarangMaster;
use App\BrgJualMaster;
use App\BiayaBulananMaster;
use Datetime;
use Auth;
use Session;

class MasterController extends Controller
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

    public function index()
    {
    	$bms = BarangMaster::all();
    	return view('master.laundry', compact('bms'));
    }

    public function laundrySave(Request $req)
    {
        $bm = new BarangMaster;
        $bm->nama = $req->nama;
        $bm->harga_laundry = $req->hLaundry;
        $bm->harga_setrika = $req->hSetrika;
        $bm->keterangan = $req->ket;
        $bm->qty = $req->qty;
        $bm->add_by = Auth::user()->id;
        $bm->created_at = $this->dateNow;
        $bm->updated_at = $this->dateNow;
        $bm->save();
        Session::flash('message', 'Data Berhasil Ditambahkan');
        return redirect('master/laundry');
    }

    public function laundryDelete($id)
    {
        $bm = BarangMaster::find($id);
        $bm->delete();
        Session::flash('message', 'Data Berhasil Dihapus');
        return redirect('master/laundry');
    }

    public function laundryDeleteM(Request $req)
    {
        $jum = count($req->id);
        if($jum)
        {
            for($i=0;$i<$jum;$i++)
            {
                $bm = BarangMaster::find($req->id[$i]);
                $bm->delete();
            }
            Session::flash('message', 'Data Berhasil Dihapus');
        } else {
            Session::flash('error', 'Data Gagal Dihapus');
        }
        return redirect('master/laundry');
    }

    public function laundryUpdate(Request $req)
    {
        $bm = BarangMaster::find($req->id);
        $bm->nama = $req->edNama;
        $bm->harga_laundry = $req->edHLaundry;
        $bm->harga_setrika = $req->edHSetrika;
        $bm->keterangan = $req->edKet;
        $bm->qty = $req->edQty;
        $bm->add_by = Auth::user()->id;
        $bm->created_at = $this->dateNow;
        $bm->updated_at = $this->dateNow;
        $bm->save();
        Session::flash('message', 'Data Berhasil Diupdate');
        return redirect('master/laundry');
    }

    //====================FUNGSI UNTUK MASTER PENJUALAN=======================
    public function penjualan()
    {
        $brs = BrgJualMaster::all();
        return view('master.penjualan', compact('brs'));
    }

    public function masterpenjualansave(Request $req)
    {
        $br = new BrgJualMaster;
        $br->nama = $req->nama;
        $br->hpp = $req->hpp;
        $br->h_jual = $req->hJual;
        $br->keterangan = $req->ket;
        $br->stok = $req->stok;
        $br->add_by = Auth::user()->id;
        $br->created_at = $this->dateNow;
        $br->updated_at = $this->dateNow;
        $br->save();
        Session::flash('message', 'Data Berhasil Ditambahkan');
        return redirect('master/penjualan');
    }

    public function masterpenjualanupdate(Request $req)
    {
        $br = BrgJualMaster::find($req->id);
        $br->nama = $req->edNama;
        $br->hpp = $req->edhpp;
        $br->h_jual = $req->edhJual;
        $br->keterangan = $req->edKet;
        $br->stok = $req->edstok;
        $br->add_by = Auth::user()->id;
        $br->created_at = $this->dateNow;
        $br->updated_at = $this->dateNow;
        $br->save();
        Session::flash('message', 'Data Berhasil Dupdate');
        return redirect('master/penjualan');
    }

    public function masterpenjualandelete($id)
    {
        $bm = BrgJualMaster::find($id);
        $bm->delete();
        Session::flash('message', 'Data Berhasil Dihapus');
        return redirect('master/penjualan');
    }

    public function masterpenjualandeletem(Request $req)
    {
        $jum = count($req->id);
        if($jum)
        {
            for($i=0;$i<$jum;$i++)
            {
                $bm = BrgJualMaster::find($req->id[$i]);
                $bm->delete();
            }
            Session::flash('message', 'Data Berhasil Dihapus');
        } else {
            Session::flash('error', 'Data Gagal Dihapus');
        }
        return redirect('master/penjualan');
    }

    public function index_biayabulanan()
    {
        $bbs = BiayaBulananMaster::all();
        return view('master.biayabulanan', compact('bbs'));
    }

    public function biayaBulananMasterSave(Request $req)
    {
        $bb = new BiayaBulananMaster;
        $bb->nama = $req->nama;
        $bb->biaya = $req->harga;
        $bb->keterangan = $req->ket;
        $bb->add_by = Auth::user()->id;
        $bb->created_at = $this->dateNow;
        $bb->updated_at = $this->dateNow;
        $bb->save();

        Session::flash('message', 'Data Berhasil Ditambahkan');
        return redirect('master/biayabulanan');
    }

    public function biayaBulananMasterUpdate(Request $req)
    {
        $bb = BiayaBulananMaster::find($req->id);
        $bb->nama = $req->edNama;
        $bb->biaya = $req->edHarga;
        $bb->keterangan = $req->edKet;
        $bb->add_by = Auth::user()->id;
        $bb->created_at = $this->dateNow;
        $bb->updated_at = $this->dateNow;
        $bb->save();

        Session::flash('message', 'Data Berhasil DiUpdate');
        return redirect('master/biayabulanan');
    }

    public function biayaBulananMasterDelete($id)
    {
        $bb = BiayaBulananMaster::find($id);
        $bb->delete();

        Session::flash('message', 'Data Berhasil DiHapus');
        return redirect('master/biayabulanan');
    }

    public function biayaBulananMasterDelMultiple(Request $req)
    {
        $jum = count($req->id);
        if($jum)
        {
            for($i=0;$i<$jum;$i++)
            {
                $bb = BiayaBulananMaster::find($req->id[$i]);
                $bb->delete();
            }
            Session::flash('message', 'Data Berhasil DiHapus');
        } else {
            Session::flash('error', 'Empty Data');
        }
        return redirect('master/biayabulanan');
    }

}
