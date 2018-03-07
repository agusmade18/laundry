<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\BarangMaster;
use App\LaundryDetail;
use App\LaundryHeader;
use App\Customer;
use App\KasBesar;
use Session;
use Datetime;
use Auth;

class LaundryController extends Controller
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

    public function transaksi()
    {
        $bms = BarangMaster::all();
        $lDetails = LaundryDetail::where('kode', '=', session()->get('transaksi'))->get();
        $i = 1;
        $totQty = 0;
        $dateNow = Carbon::now()->addDays(2)->toDateString();
        $dateNow = date('m/d/Y', strtotime($dateNow));
    	return view('laundry.transaksi', compact('bms', 'lDetails', 'i', 'totQty', 'dateNow'));
    }

    public function saveDetail(Request $req)
    {
        $kode = session()->get('transaksi');
        if($kode)
        {
            $total = ($req->harga * $req->qty)+$req->hanger+$req->express-$req->disN;
            $ld                 = new LaundryDetail;
            $ld->id_barang      = $req->id;
            $ld->qty            = $req->qty;
            $ld->total          = $total;
            $ld->diskon_persen  = $req->disP;
            $ld->diskon_nominal = $req->disN;
            $ld->kode           = $kode;
            $ld->hanger         = $req->hanger;
            $ld->express        = $req->express;
            $ld->harga          = $req->harga;
            $ld->jenis          = $req->jenis;
            $ld->closed         = "0";
            $ld->created_at     = $this->dateNow;
            $ld->updated_at     = $this->dateNow;
            $ld->save();

            return redirect('laundry/transaksi');
        } else {
            Session::flash('message', 'Program Belum Diaktivasi... Cp (081237361059)');
            return redirect('/login');
        }
    }

    public function saveHeader(Request $req)
    {
        $kode = session()->get('transaksi');
        //$this->print($kode);
        $dateNow = Carbon::now()->toDateString();

        //save customer
        $cs = new Customer;
        $cs->nama       = $req->namaCust;
        $cs->alamat     = $req->alamat;
        $cs->phone      = $req->phone;
        $cs->created_at = $this->dateNow;
        $cs->updated_at = $this->dateNow;
        $cs->save();

        $ld = LaundryDetail::where('kode', '=', $kode)->get();
        $getTotal = $ld->sum('total');
        $gTotal = $getTotal - $req->disTotalN;

        $lh = new LaundryHeader;
        $lh->kode           = $kode;
        $lh->admin          = Auth::user()->id;
        $lh->total          = $getTotal;
        $lh->diskon_persen  = $req->disTotalP;
        $lh->diskon_nominal = $req->disTotalN;
        $lh->tgl_masuk      = $dateNow;
        $lh->tgl_keluar     = date('Y-m-d', strtotime($req->tglAmbil));
        $lh->id_customer    = $cs->id;
        $lh->grand_total    = $gTotal;
        $lh->bayar          = $req->bayar;
        $lh->status         = "proses";
        $lh->keterangan     = $req->keterangan;
        $lh->closed         = "0";
        $lh->created_at     = $this->dateNow;
        $lh->updated_at     = $this->dateNow;
        $lh->save();

        $this->print($kode);

        session()->forget('transaksi');
        $kode = "LND-".$this->makeCode();
        session()->put('transaksi', $kode);
        
        Session::flash('message', 'Data Transaksi Berhasil Ditambahkan');
        return redirect('laundry/transaksi');
    }

    public function makeCode()
    {
      $lastId = 0;
      if(LaundryHeader::count())
      {
        $lastId = LaundryHeader::orderBy('id', 'desc')->first()->id + 1;
      } else {
        $lastId = 1;
      }
      $lastId = sprintf("%04d", $lastId);
      return $lastId;
    }

    public function delete($id)
    {
        $ld = LaundryDetail::find($id);
        $ld->delete();
        return redirect('laundry/transaksi');
    }

    public function index()
    {
        $lhs = LaundryHeader::where('status', '=', 'proses')->get();
        $del = LaundryHeader::where('status', '=', 'delete')->get();
        $don = LaundryHeader::where('status', '=', 'done')->get();
        return view('laundry.view', compact('lhs', 'del', 'don'));
    }

    public function transaksiDone()
    {
        $lhs = LaundryHeader::where('status', '=', 'done')->get();
        return view('laundry.done', compact('lhs'));
    }

    public function print($kode)
    {
        $lh = LaundryHeader::where('kode', '=', $kode)->first();
        $lDetails = LaundryDetail::where('kode', '=', $kode)->orderBy('jenis')->get();
        $i = 1;

        $tmpdir = sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
        $file =  tempnam($tmpdir, 'ctk'); # nama file temporary yang akan dicetak
        $handle = fopen($file, 'w');
        $condensed = Chr(27) . Chr(33) . Chr(4);
        $bold1 = Chr(27) . Chr(69);
        $bold0 = Chr(27) . Chr(70);
        $initialized = chr(27).chr(64);
        $condensed1 = chr(15);
        $condensed0 = chr(18);

        $Data  = $initialized;
        $Data .= $condensed1;
        $Data .= "-----------------------------------------------------------------\n";
        $Data .= "|     ".$bold1."FRESH LAUNDRY".$bold0."      | Jalan Letda Reta No. 20 Denpasar | \n";
        $Data .= "| Jam Buka 08.00 - 20.00  | No. Telephone : 085-739-339-461 | \n";
        $Data .= "-----------------------------------------------------------------\n";

        $Data .= " Kode          : ".$lh->kode."\n";
        $Data .= " Nama Customer : ".$lh->myCustomer->nama." ( ".$lh->myCustomer->phone." )\n";
        $Data .= " Alamat        : ".$lh->myCustomer->alamat."\n";
        $Data .= " Tgl. Msk/Klr  : ".date('d M Y', strtotime($lh->tgl_masuk))." / ". date('d M Y', strtotime($lh->tgl_keluar))."\n";
        $Data .= " Kasir         : ".Auth::user()->name."\n";
        $Data .= "-----------------------------------------------------------------\n";
        $Data .= "                          Data Barang\n";
        $Data .= "-----------------------------------------------------------------\n";
        $no = 3;
        $nama = 16;
        $qty = 4;
        $harga = 6;
        $diskon = 6;
        $jenis = 7;
        $total = 8;

        $Data .= " No | Nama Barang     | Qty | Harga |Dis(%)| Jenis  |  Total   |\n";
        $Data .= "-----------------------------------------------------------------\n";
        foreach($lDetails as $ld)
        {
            $Data .= " ".$i++;
            for($j=0;$j<$no-strlen($i);$j++)
            {
                $Data .= " ";
            }
            $Data .= "| ".str_limit($ld->barang->nama, 13);
            for($j=0;$j<$nama-strlen($ld->barang->nama);$j++)
            {
                $Data .= " ";
            }
            $Data .= "| ".$ld->qty;
            for($j=0;$j<$qty-strlen($ld->qty);$j++)
            {
                $Data .= " ";
            }
            $Data .= "| ".number_format($ld->harga);
            for($j=0;$j<$harga-strlen(number_format($ld->harga));$j++)
            {
                $Data .= " ";
            }
            $Data .= "|".$ld->diskon_persen;
            for($j=0;$j<$diskon-strlen($ld->diskon_persen);$j++)
            {
                $Data .= " ";
            }
            $Data .= "| ".$ld->jenis;
            for($j=0;$j<$jenis-strlen($ld->jenis);$j++)
            {
                $Data .= " ";
            }
            $Data .= "| ".number_format($ld->total);
            for($j=0;$j<$total-strlen($ld->total);$j++)
            {
                $Data .= " ";
            }
            $Data .= "|\n";
            //$Data .= " ".$i++." | ".$ld->barang->nama."       | ".$ld->qty." | ".number_format($ld->harga)." | ".$ld->diskon_persen." | ".$ld->jenis."  |  ".number_format($ld->total)."  |\n";
        }
        $Data .= "-----------------------------------------------------------------\n";

        $Data .= "  Keterangan    : ".$lh->keterangan."\n" ;
        $totQty = 0;
        foreach($lDetails as $ld){
          $totQty = $totQty + ($ld->barang->qty*$ld->qty);
        }
        $Data .= "  Sub Total/Qty : Rp ".number_format($lDetails->sum('total'))." / ".$totQty." Pcs\n" ;
        $Data .= "  Diskon        : ";
        $Data .= $lh->diskon_persen == '' ? '0' : $lh->diskon_persen."%";
        $Data .= " / ";
        $Data .= $lh->diskon_nominal == '' ? 'Rp 0'."\n" : "Rp ".number_format($lh->diskon_nominal)."\n";
        $Data .= "  Grand Total   : Rp ".number_format($lh->grand_total)."\n";
        $Data .= "  Bayar         : Rp ".number_format($lh->bayar)."\n";

        $Data .= "  ";
        $Data .= $lh->bayar >= $lh->grand_total ? 'Kembalian     : ' : 'Kurg Byr      : ';
        $Data .= $lh->bayar >= $lh->grand_total ? "Rp ".number_format($lh->bayar-$lh->grand_total)."\n\n" : "Rp ".number_format(($lh->bayar-$lh->grand_total)*-1)."\n\n";
        $Data .= "   Customer\n\n\n";
        $Data .= "   ".$lh->myCustomer->nama."\n\n\n\n\n\n\n\n\n\n\n\n";
        fwrite($handle, $Data);
        fclose($handle);
        try {
            $tt = copy($file, "//192.168.2.71/xprinter");   # Lakukan cetak
        }
        catch (\Exception $e) {
            Session::flash('error', 'Printer Tidak Terdeteksi...');
        }
        unlink($file);
        return redirect('laundry/view');
    }

    public function done($kode)
    {
        $lh = LaundryHeader::where('kode', '=', $kode)->first();
        $lh->status = "done";
        $lh->tgl_keluar = Carbon::now()->toDateString();
        if($lh->bayar < $lh->grand_total)
        {
            $lh->bayar = $lh->grand_total;
        }
        $lh->save();

        $kb = new KasBesar;
        $kb->id_fk      = $lh->id;
        $kb->tanggal    = Carbon::now()->toDateString();
        $kb->harga      = $lh->grand_total;
        $kb->qty        = "1";
        $kb->debit      = $lh->grand_total;
        $kb->kredit     = '0';
        $kb->jenis      = 'Pendapatan Jasa';
        $kb->keterangan = $kode;
        $kb->closed     = '0';
        $kb->add_by     = Auth::user()->id;
        $kb->created_at = $this->dateNow;
        $kb->updated_at = $this->dateNow;
        $kb->save();

        Session::flash('message', 'Transaksi Kode '.$kode.' Selesai...!');
        return redirect('laundry/view');
    }

    public function detail($kode)
    {
        $lh = LaundryHeader::where('kode', '=', $kode)->first();
        $lDetails = LaundryDetail::where('kode', '=', $kode)->get();
        return view('laundry/detail', compact('lh', 'lDetails'));
    }

    public function batal($kode)
    {
        $lh = LaundryHeader::where('kode', '=', $kode)->first();
        $lh->status = "delete";
        $lh->save();

        Session::flash('message', 'Data Transaksi Berhasil Dibatalkan...!');

        return redirect('laundry/view');
    }

    public function search(Request $req)
    {
        $lhs = LaundryHeader::where('status', '=', 'proses')
        ->where('kode', 'LIKE', '%'.$req->q.'%')->get();
        return view('laundry.search', compact('lhs'));
    }

    public function multipleDo(Request $req)
    {
        $jum = count($req->id);
        if($jum)
        {
            if($req->selesai)
            {
                for($i=0;$i<$jum;$i++)
                {
                    $lh = LaundryHeader::find($req->id[$i]);
                    $lh->status = "done";
                    if($lh->bayar < $lh->grand_total)
                    {
                        $lh->bayar = $lh->grand_total;
                    }

                    $kb = new KasBesar;
                    $kb->id_fk      = $lh->id;
                    $kb->tanggal    = Carbon::now()->toDateString();
                    $kb->harga      = $lh->grand_total;
                    $kb->qty        = '1';
                    $kb->debit      = $lh->grand_total;
                    $kb->kredit     = '0';
                    $kb->jenis      = 'Pendapatan Jasa';
                    $kb->keterangan = $lh->kode;
                    $kb->closed     = '0';
                    $kb->add_by     = Auth::user()->id;
                    $kb->created_at = $this->dateNow;
                    $kb->updated_at = $this->dateNow;

                    $lh->save();
                    $kb->save();
                }
                Session::flash('message', 'Data Transaksi Telah Diselesaikan...');
            } elseif($req->batal)
            {
                for($i=0;$i<$jum;$i++)
                {
                    $lh = LaundryHeader::find($req->id[$i]);
                    $lh->status = "delete";
                    $lh->save();
                }
                Session::flash('message', 'Data Transaksi Berhasil Dibatalkan...!');
            }
        } else {
            Session::flash('error', 'Tidak Ada Data yang Dipilih...');
        }
        return redirect('laundry/view');
    }

    public function canceledTransaksi()
    {
        $lhs = LaundryHeader::where('status', '=', 'delete')->get();
        return view('laundry.delete', compact('lhs'));
    }

    public function hapusPermanen($kode)
    {
        $lh = LaundryHeader::where('kode', '=', $kode)->first();
        $lh->delete();
        $ld = LaundryDetail::where('kode', '=', $kode)->delete();
        return redirect('laundry/canceledTransaksi');
    }

    public function multipleDelete(Request $req)
    {
        $jum = count($req->kode);
        if($jum)
        {
            for($i=0;$i<$jum;$i++)
            {
                $lh = LaundryHeader::where('kode', '=', $req->kode[$i])->first();
                $lh->delete();
                $ld = LaundryDetail::where('kode', '=', $req->kode[$i])->delete();
            }
            Session::flash('message', 'Data Berhasil Dihapus');
        } else {
            Session::flash('error', 'Empty Data...');
        }
        return redirect('laundry/canceledTransaksi');
    }

    public function bayar(Request $req)
    {
        $lh = LaundryHeader::where('kode', '=', $req->code)->first();
        $lh->status = "done";
        $lh->tgl_keluar = $this->dateNow;
        if($lh->bayar < $lh->grand_total)
        {
            $lh->diskon_persen = $req->disP;
            $lh->diskon_nominal = $req->disN;
            $lh->bayar = $req->bayar;
            $lh->grand_total = $lh->total - $req->disN;
            $lh->bayar = $req->bayar;
        }
        $lh->save();

        $kb = new KasBesar;
        $kb->id_fk      = $lh->id;
        $kb->tanggal    = $this->dateNow;
        $kb->harga      = $lh->grand_total;
        $kb->qty        = "1";
        $kb->debit      = $lh->grand_total;
        $kb->kredit     = '0';
        $kb->jenis      = 'Pendapatan Jasa';
        $kb->keterangan = $req->code;
        $kb->closed     = '0';
        $kb->add_by     = Auth::user()->id;
        $kb->created_at = $this->dateNow;
        $kb->updated_at = $this->dateNow;
        $kb->save();

        Session::flash('message', 'Transaksi Kode '.$req->code.' Selesai...!');
        return redirect('laundry/view');
    }
}
