<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.tables');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listBarang(){
        try{
            $dataBarang = DB::table('barang')->get();
            return response()->json($dataBarang);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function addBarang(Request $request){
        try{
            DB::table('barang')->insert([
                'nama_barang' => $request->namaBarang,
                'harga_barang' => $request->hargaBarang,
                'jumlah_barang' => $request->qtyBarang,
                'satuan_barang' => $request->satuanBarang,
            ]);

            return response()->json('success');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteBarang(Request $request){
        try{
            $delete = Barang::find($request->id);
            $delete->delete();

            return response()->json('success');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function editBarang(Request $request){
        try{
            dd($request->all);
            return response()->json('success');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function printInvoice(Request $request){
        try{
            $nama = [];
            foreach($request->datatable as $key => $value){
                $nama[] = $value['nama_barang'];
            }
            $harga = [];
            foreach($request->datatable as $key => $value){
                $harga[] = $value['harga_barang'];
            }
            $jumlah = [];
            foreach($request->datatable as $key => $value){
                $jumlah[] = $value['jumlah_barang'];
            }
            $satuan = [];
            foreach($request->datatable as $key => $value){
                $satuan[] = $value['satuan_barang'];
            }

            foreach($nama as $key => $value) {
                $data[] = [
                    "nama_barang" => $nama[$key],
                    "harga_barang" => $harga[$key],
                    'jumlah_barang' => $jumlah[$key],
                    'satuan_barang' => $satuan[$key],
                ];
            }

            $footer[] = [
                'data_qty' => $request->dataqty,
                'data_dp' => $request->datadp,
                'data_disc' => $request->datadisc,
                'data_sum' => $request->datasum,
                'data_total' => $request->datatotal,
            ];

            $noInvoice = DB::table('terjual')->get();
            $inv = json_decode($noInvoice, true);

            $header[] = [
                'data_nama' => $request->dataNama,
                'data_alamat' => $request->dataAlamat,
                'data_up' => $request->dataUp,
            ];



            $transaksi = [
                'barangterjual' => $data,
                'data_qty' => $request->dataqty,
                'data_dp' => $request->datadp,
                'data_disc' => $request->datadisc,
                'data_sum' => $request->datasum,
                'data_total' => $request->datatotal,
                'data_nama' => $request->dataNama,
                'data_up' => $request->dataUp,
                'data_alamat' => $request->dataAlamat,
            ];

            if($inv == null){
                $nomer = 1;
            } else {
                foreach($inv as $inv){
                    if($inv['tanggal'] !== date("d-m-Y")){
                        $nomer = 1;
                    } else {
                        $nomer = $inv['nomer'] + 1;
                    }
                }
            }

            DB::table('terjual')->insert([
                'nomer' => $nomer,
                'transaksi' => json_encode($transaksi),
                'tanggal' => date("d-m-Y")
            ]);

            $view = [
                'data' => view('pages.print', compact('data','header','footer', 'nomer'))->render(),
            ];
        return response()->json($view);
    } catch (\Exception $e) {
        return $e->getMessage();
    }
    }
}
