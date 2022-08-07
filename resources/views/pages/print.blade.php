@extends('layouts.app', ['activePage' => 'printTable', 'titlePage' => __('Print')])
<link href="{{ asset('assets/css/tableInvoice.css') }}" rel="stylesheet" type="text/css" >
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="page-content container">
    <div class="container px-0">
        <div class="row mt-4">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center text-150">
                            <img src="{{ asset('assets/img/header/header.jpeg') }}">
                        </div>
                    </div>
                </div>
                <hr class="row brc-default-l1 mx-n1 mb-4"/>
                        <div class="row">
                            <div class="col-sm-6">
                                    <div>
                                        <span class="text-sm text-grey-m2 align-middle">Kepada  :</span>
                                        <span class="text-600 text-110 text-black align-middle">{{$header[0]['data_nama']}}</span>
                                    </div>
                                    <div>
                                        <span class="text-sm text-grey-m2 align-middle">UP  :</span>
                                        @if($header[0]['data_up'] == null)
                                            <span class="text-600 text-110 text-black align-middle">
                                                -
                                            </span>
                                        @else
                                            <span class="text-600 text-110 text-black align-middle">
                                                {{$header[0]['data_up']}}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-sm text-grey-m2 align-middle">Alamat  :</span>
                                        <span class="text-600 text-110 text-black align-middle">{{$header[0]['data_alamat']}}</span>
                                    </div>
                                </div>
                                <div class="text-95 col-sm-6 align-end d-sm-flex justify-content-end">
                                    <hr class="d-sm-none" />
                                    <div class="text-grey-m2">
                                        <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125 text-right">
                                            Gianyar, {{date('d-m-Y')}}
                                        </div>
                                        <div class="mt-6 mb--4 text-secondary-m1 text-600 text-125 text-right">
                                            Nomor Invoice : IN{{$nomer}}{{date('d-m-Y')}}
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="border border-white text-center">
                            INVOICE
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>KETERANGAN</th>
                                        <th>HARGA (Rp) SATUAN</th>
                                        <th>QTY</th>
                                        <th>TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody class="text-95 text-secondary-d3 text-center">
                                    @foreach ($data as $key => $value)
                                        <tr></tr>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value['nama_barang']}}</td>
                                            <td>Rp {{number_format($value['harga_barang'],0,',','.')}}</td>
                                            <td class="text-95">{{$value['jumlah_barang']/$value['harga_barang']}}</td>
                                            <td class="text-secondary-d2">{{$value['satuan_barang']}}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                                <tfoot>
                                    @foreach ($footer as $data)
                                    <tr>
                                        <th colspan="4" style="text-align:right">Sub Total :</th>
                                        <th>{{$data['data_sum']}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="text-align:right">Down Payment :</th>
                                        <th>{{$data['data_dp']}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="text-align:right">Disc :</th>
                                        <th>{{$data['data_disc']}}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="text-align:right">Total :</th>
                                        <th>{{$data['data_total']}}</th>
                                    </tr>
                                    @endforeach
                                </tfoot>
                            </table>
                        </div>
                        <div class="container">
                            <div class="row">
                              <div class="col-6">
                                <div class="row">
                                    <div class="col-5">
                                      Nomor Rekening
                                    </div>
                                    <div class="col-0">
                                        :
                                    </div>
                                    <div class="col-5">
                                      669-025-3176
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-5">
                                      Bank
                                    </div>
                                    <div class="col-0">
                                        :
                                    </div>
                                    <div class="col-5">
                                      BCA
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-5">
                                      Nama Pemilik Rekening
                                    </div>
                                    <div class="col-0">
                                        :
                                    </div>
                                    <div class="col-5">
                                      I Wayan Pujito Adnyana
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm">
                                        <br> Diterima Oleh, <br> <br> <br>(&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;)
                                    </div>
                                  </div>
                              </div>
                              <div class="col-6">
                                <div class="row">
                                    <div class="col-sm">
                                        <br>
                                    </div>
                                </div>
                                <div class="row pl-9 ml-5">
                                    <div class="col-sm text-center">
                                      Hormat Kami, <br> {{ auth()->user()->jabatan }} <br> PT. Eka Teknologi Solusi
                                    </div>
                                </div>
                                <div class="row pl-9 ml-5">
                                    <div class="col-sm text-center">
                                      <br> <br> <br> {{ auth()->user()->name }}
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                    <hr/>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="text-center text-150">
                        <img src="{{ asset('assets/img/footer/footer.jpeg') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
