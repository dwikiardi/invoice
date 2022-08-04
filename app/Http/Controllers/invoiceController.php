<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class invoiceController extends Controller
{
    public function index(){
        return view('pages.invoice');
    }

    public function invoice(){
        try{
            $dataInvoice = DB::table('terjual')->get();
            $arrInvoice = json_decode($dataInvoice, true);

            $nomerinv = [];
            foreach($arrInvoice as $nomer){
                $nomerinv[] = 'INV' . $nomer['nomer'] . $nomer['tanggal'];
            }

            $dataterjual = [];
            foreach($arrInvoice as $data){
                $dataterjual[] = json_decode($data['transaksi'], true);
            }

            $namapelanggan = [];
            foreach($dataterjual as $data){
                $namapelanggan[] = $data['data_nama'];
            }

            $alamatpelanggan = [];
            foreach($dataterjual as $data){
                $alamatpelanggan[] = $data['data_alamat'];
            }

            $datasum = [];
            foreach($dataterjual as $data){
                $datasum[] = $data['data_sum'];
            }

            $datatotal = [];
            foreach($dataterjual as $data){
                $datatotal[] = $data['data_total'];
            }

            $datadisc = [];
            foreach($dataterjual as $data){
                $datadisc[] = $data['data_disc'];
            }

            $datadp = [];
            foreach($dataterjual as $data){
                $datadp[] = $data['data_dp'];
            }

            $databarang = [];
            foreach($dataterjual as $data){
                $databarang[] = $data['barangterjual'];
            }

            $data = [];
            foreach($nomerinv as $key => $value) {
                $data[] = [
                    "nomer_inv" => $nomerinv[$key],
                    "nama_pelanggan" => $namapelanggan[$key],
                    'alamat_pelanggan' => $alamatpelanggan[$key],
                    'data_sum' => $datasum[$key],
                    'data_dp' => $datadp[$key],
                    'data_disc' => $datadisc[$key],
                    'data_total' =>  $datatotal[$key],
                    'data_barang' => $databarang[$key]
                ];
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
