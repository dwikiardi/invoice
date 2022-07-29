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

            $header[] = [
                'data_nama' => $request->dataNama,
                'data_alamat' => $request->dataAlamat,
            ];

            $view = [
                'data' => view('pages.print', compact('data','header','footer'))->render(),
            ];
            $transaksi = [
                'barangterjual' => $data,
                'data_qty' => $request->dataqty,
                'data_dp' => $request->datadp,
                'data_disc' => $request->datadisc,
                'data_sum' => $request->datasum,
                'data_total' => $request->datatotal,
                'data_nama' => $request->dataNama,
                'data_alamat' => $request->dataAlamat,
            ];

            $noInvoice = DB::table('terjual')->get();
            $inv = json_decode($noInvoice, true);

            foreach($inv as $data){
                if($data['tanggal'] == date("d-m-Y")){
                    DB::table('terjual')->insert([
                        'transaksi' => json_encode($transaksi),
                        'tanggal' => date("d-m-Y")
                    ]);
                } else {

                }
            }
            // dd($inv[0]['tanggal']);
            // $jsonTransaksi = json_encode($transaksi);
            // dd($jsonTransaksi);



            return response()->json($view);
    } catch (\Exception $e) {
        return $e->getMessage();
    }
    }
}
