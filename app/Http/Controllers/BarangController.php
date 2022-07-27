<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function printInvoice(Request $request){
        return view('pages.print')->with([
                'data_barang' => $request->datatable,
                'data_qty' => $request->dataqty,
                'data_dp' => $request->datadp,
                'data_disc' => $request->datadisc,
                'data_sum' => $request->datasum,
                'data_total' => $request->datatotal,
            ]);
    }
}
