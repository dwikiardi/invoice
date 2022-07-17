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
                
            ]);

            return response()->json('success');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
