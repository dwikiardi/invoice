@extends('layouts.app', ['activePage' => 'table-list', 'titlePage' => __('TABLE')])

@section('content')
    <div class="header bg-gradient-primary pb-4 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0 pl-3">
                        <div class="row">
                            <h3 class="mb--1 col-10">Data Barang</h3>
                            <div class="col-2"><button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#exampleModal">Tambah</button></div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive p-3 mt--3">
                        <table class="table align-items-center table-flush" id="listBarang">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Keterangan</th>
                                    <th scope="col" class="sort" data-sort="budget">Harga (Rp) satuan</th>
                                    <th scope="col" class="sort" data-sort="status">Qty</th>
                                    <th scope="col" class="sort" data-sort="completion">Satuan</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header border-0">
                        <h3 class="mb-0">Barang Terjual</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Keterangan</th>
                                    <th scope="col" class="sort" data-sort="budget">Harga (Rp) satuan</th>
                                    <th scope="col" class="sort" data-sort="status">Qty</th>
                                    <th scope="col" class="sort" data-sort="completion">Satuan</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal tambah barang --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-light">
              <h5 class="modal-title" id="exampleModalLongTitle">Tambah Barang</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-white">
                <form id="form-barang">
                    <div class="form-group">
                      <label for="nama-barang">Nama Barang</label>
                      <input type="text" class="form-control" name="namaBarang" id="namaBarang">
                    </div>
                    <div class="form-group">
                      <label for="harga-barang">Harga</label>
                      <input type="text" class="form-control" name="hargaBarang" id="hargaBarang">
                    </div>
                    <div class="form-group">
                        <label for="qty-barang">qty</label>
                        <input type="text" class="form-control" name="qtyBarang" id="qtyBarang">
                      </div>
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-tambah">Tambah Data</button>
            </div>
          </div>
        </div>
      </div>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#listBarang').DataTable({
                "autoWidth": false,
                'ajax': {
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'type': "GET",
                        'url': "/list/barang",
                        'dataSrc': function (response) {
                            return response;
                        },
                    },
                'columns' : [
                    {'data' : 'nama_barang'},
                    {'data' : 'harga_barang'},
                    {'data' : 'jumlah_barang'},
                ],
                "oLanguage": {
                        "oPaginate": {
                            "sPrevious": "<<", // This is the link to the previous page
                            "sNext": ">>", // This is the link to the next page
                    }
                }
            })

            $('.btn-tambah').on('click', function () { 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let form = $('#form-barang')[0]
                let data = new FormData(form)
                $.ajax({
                    type: "POST",
                    url: "/list/addbarang",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (response) {
                        console.log(response)
                    },
                    error: function(response){
                        console.log(response)
                    }
                });     
            });
        });
    </script>
@endpush
