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
                            <h3 class="mb--1 col-7">Data Barang</h3>
                            <div class="col-3"><button type="button" class="btn btn-sm btn-primary float-right mr-1" data-toggle="modal" data-target="#modalBarang">Tambah</button></div>
                            <div class="col-2"><button type="button" class="btn btn-sm btn-success btnJual float-right mr--2">Add to Invoice Table</button></div>
                        </div>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive p-3 mt--3">
                        <table class="table table-bordered display" id="listBarang">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Keterangan</th>
                                    <th scope="col" class="sort" data-sort="budget">Harga (Rp) satuan</th>
                                    <th scope="col" class="sort" data-sort="status">Qty</th>
                                    <th scope="col" class="sort" data-sort="completion">Satuan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="card p-3 mt-3">
                    <div class="card-header border-0 p-1">
                        <div class="row">
                            <h3 class="mb--1 col-8">Data Invoice</h3>
                            <div class="col-3"><button type="button" class="btn btn-sm btn-primary float-right mr-4" data-toggle="modal" data-target="#modalInvoice">Tambah invoice</button></div>
                            <div class="col-1"><button type="button" class="btn btn-sm btn-success float-right ml--2 btn-export">Export PDF</button></div>
                        </div>
                    </div>
                    <div class="table-responsive p-1 mt-3">
                        <table class="table table-bordered display" id="invoiceBarang">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Keterangan</th>
                                    <th scope="col" class="sort" data-sort="budget">Harga (Rp) satuan</th>
                                    <th scope="col" class="sort" data-sort="status">Qty</th>
                                    <th scope="col" class="sort" data-sort="completion">Satuan</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody id="invoice"></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"style="text-align:right">Sub Total :</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4"  style="text-align:right">Down Payment :</th>
                                    <th><input type="text" class="form-control form-control-sm touch" name="dp" id="dp" placeholder="Input DP" /></th>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align:right">Discount :</th>
                                    <th><input type="text" class="form-control form-control-sm touch" name="disc" id="disc" placeholder="Input Disc" /></th>
                                </tr>   
                                <tr>
                                    <th colspan="4" style="text-align:right">Total :</th>
                                    <th></th>
                                </tr> 
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal tambah barang --}}
    <div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="modalBarang" aria-hidden="true">
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
                      <label for="nama-barang">Keterangan</label>
                      <input type="text" class="form-control" name="namaBarang" id="namaBarang">
                    </div>
                    <div class="form-group">
                      <label for="harga-barang">Harga</label>
                      <input type="text" class="form-control" name="hargaBarang" id="hargaBarang">
                    </div>
                    <div class="form-group">
                        <label for="qty-barang">Qty</label>
                        <input type="text" class="form-control" name="qtyBarang" id="qtyBarang">
                    </div>
                    <div class="form-group">
                        <label for="satuan-barang">Satuan</label>
                        <input type="text" class="form-control" name="satuanBarang" id="satuanBarang">
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

      {{-- Modal tambah invoice --}}
    <div class="modal fade" id="modalInvoice" tabindex="-1" role="dialog" aria-labelledby="modalInvoice" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-light">
              <h5 class="modal-title" id="exampleModalLongTitle">Tambah Invoice</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-white">
                <form id="form-invoice">
                    <div class="form-group">
                      <label for="nama-barang">Nama Barang</label>
                      <input type="text" class="form-control" name="namaBarang" id="namaBarang">
                    </div>
                    <div class="form-group">
                      <label for="harga-barang">Harga</label>
                      <input type="text" class="form-control" name="hargaBarang" id="hargaBarang">
                    </div>
                    <div class="form-group">
                        <label for="qty-barang">Qty</label>
                        <input type="text" class="form-control" name="qtyBarang" id="qtyBarang">
                    </div>
                    <div class="form-group">
                        <label for="satuan-barang">Satuan</label>
                        <input type="text" class="form-control" name="satuanBarang" id="satuanBarang">
                    </div>
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary btn-sm tbhInvoice">Tambah invoice</button>
            </div>
          </div>
        </div>
      </div>

@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.datatables.net/plug-ins/1.12.1/api/sum().js"></script>
    
    <script>
        $(document).ready(function () {
            var rupiah = Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            });

            var tableInvoice = $('#invoiceBarang').DataTable({
                "autoWidth": false,
                'columns' : [
                    {'data' : 'nama_barang'},
                    {'data' : 'harga_barang' , render:$.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
                    {'data' : 'jumlah_barang'},
                    {'data' : 'satuan_barang'},
                    // {'data' : 'harga_barang' , render:$.fn.dataTable.render.number( '.', ',', 0, 'Rp ',',00' )},
                ],
                columnDefs: [
                    {
                        targets: 2,
                        width: "25%",
                        render: function(data, type, full, meta) {
                        return '\<input type="text" class="form-control form-control-sm touch" name="item_quantity" id="item_quantity" placeholder="Input Qty" />';
                        },
                    },
                    {
                        targets: 4,
                        data : 'jumlah_barang', 
                        render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ),
                    }
                ],
                rowCallback: function (row, data) {
                    var val = $('input[name="item_quantity"]', row).val();
                    if ( val === '' || val === undefined ) {
                    val = 1;
                    }
                    var total = parseInt(data['harga_barang']) * val;
                    this.api().cell(row, 4).data(total);
                },
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(), data;
                    // Update footer 
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                        i.replace(/[\.,Rp]/g, '')*1 :
                        typeof i === 'number' ?
                        i : 0;
                    };

                    totalsum = api
                    .cells( null, 4, { page: 'current'} )
                    .render('display')
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    var valdp = $('input[name="dp"]').val();
                    var newdp = valdp.replace(/[\.Rp]/g, '')

                    var valdisc = $('input[name="disc"]').val();
                    var newdisc = valdisc.replace(/ %/g, '')

                    if(totalsum >= 1){
                        if(newdp >= 1){
                            var dp = totalsum - newdp;
                            if(newdisc >= 1){
                                var total = (parseFloat(newdisc)/100)*dp
                                var totalAkhir = dp - total
                            } else {
                                var totalAkhir = dp;
                            }
                        } else {
                            var totalAkhir = totalsum;
                        }
                    }
                    
                    if(totalAkhir === '' || totalAkhir === undefined){
                        totalAkhir = 0;
                    }

                    $('tr:eq(0) th:eq(1)', api.table().footer()).html(rupiah.format(totalsum));
                    $('tr:eq(1) th:eq(1)', api.table().footer()).html();
                    $('tr:eq(2) th:eq(1)', api.table().footer()).html();
                    $('tr:eq(3) th:eq(1)', api.table().footer()).html(rupiah.format(totalAkhir));
                },
                "oLanguage": {
                        "oPaginate": {
                            "sPrevious": "<<", // This is the link to the previous page
                            "sNext": ">>", // This is the link to the next page
                    }
                }
            })

            $('#invoiceBarang tbody').on('change', 'input[name="item_quantity"]', function () {
                // Update row calculations
                tableInvoice.draw(false);
            });

            $('#invoiceBarang tfoot').on('change', 'input[name="dp"]', function () {
                // Update row calculations
                // alert('footer')
                tableInvoice.draw(false);
            });

            $('#invoiceBarang tfoot #dp').keyup(function (event) {
                $(this).val(function (index, value) {
                    return 'Rp ' + value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                });
            });

            $('#invoiceBarang tfoot #disc').keyup(function (event) {
                $(this).val(function (index, value) {
                    return value.replace(/\D/g, "") + ' %';
                });
            });

            $('#invoiceBarang tfoot').on('change', 'input[name="disc"]', function () {
                // Update row calculations
                tableInvoice.draw(false);
            });
            
            var tableBarang = $('#listBarang').DataTable({
                'select' : {
                    'style' : 'multi'
                },
                "autoWidth": false,
                dom: 
                    "<'row'<'col-sm-6'l><'col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
                    {'data' : 'harga_barang', render:$.fn.dataTable.render.number( '.', ',', 0, 'Rp ' )},
                    {'data' : 'jumlah_barang'},
                    {'data' : 'satuan_barang'},
                ],
                "oLanguage": {
                        "oPaginate": {
                            "sPrevious": "<<", // This is the link to the previous page
                            "sNext": ">>", // This is the link to the next page
                    }
                }
            })

            $('body').on('click', '.tbhInvoice', function (){
                var namaBarang = $('#form-invoice #namaBarang').val()
                var hargaBarang = $('#form-invoice #hargaBarang').val()
                var qtyBarang = $('#form-invoice #qtyBarang').val()
                var satuanBarang = $('#form-invoice #satuanBarang').val()
                tableInvoice.row.add({
                        "nama_barang": namaBarang,
                        "harga_barang": hargaBarang,
                        "jumlah_barang": qtyBarang,
                        "satuan_barang": satuanBarang,
                    }).draw();
            });
            
            $('body').on('click', '.btnJual', function (){
                var dataBarang = tableBarang.rows( { selected: true } ).data();
                var data = [];
                $.each(dataBarang, function (index, value) {
                    tableInvoice.row.add({
                        "nama_barang": value.nama_barang,
                        "harga_barang": value.harga_barang,
                        "jumlah_barang": 0,
                        "satuan_barang": value.satuan_barang,
                    }).draw();
                });
            });

            $('.btn-export').on('click', function () { 
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var datatable = tableInvoice.rows().data();
                table = []
                $.each(datatable, function (index, value) {
                    table.push(value)
                });
                var dataqty = $('#invoiceBarang tbody #item_quantity').val()
                var datadp = $('#invoiceBarang tfoot #dp').val()
                var datadisc = $('#invoiceBarang tfoot #disc').val()
                var datasum = $('#invoiceBarang tfoot tr:eq(0) th:eq(1)').text()
                var datatotal = $('#invoiceBarang tfoot tr:eq(3) th:eq(1)').text()
                $.ajax({
                    type: "POST",
                    url: "/list/printInvoice",
                    data: {
                        datatable : table,
                        dataqty : dataqty,
                        datadp : datadp,
                        datadisc : datadisc,
                        datasum : datasum,
                        datatotal : datatotal
                    },
                    success: function (response) {
                        console.log(response)
                    },
                    error: function(response){
                        console.log(response)
                    }
                });     
            });

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
