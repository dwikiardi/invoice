@extends('layouts.app', ['activePage' => 'dataInvoice', 'titlePage' => __('Data Invoice')])
<link href="{{ asset('assets/css/invoicedetail.css') }}" rel="stylesheet" type="text/css" >

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
                            <h3 class="mb--1 col-7">Data Invoice</h3>
                        </div>
                    </div>
                    <!-- Light table -->
                        <div class="table-responsive p-3 mt--3">
                            <table class="table table-bordered display" id="invoiceTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th></th>
                                        <th scope="col" class="sort" data-sort="name">Nomer Invoice</th>
                                        <th scope="col" class="sort" data-sort="budget">Nama Pelanggan</th>
                                        <th scope="col" class="sort" data-sort="status">Alamat Pelanggan</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
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
    <script src="{{asset('functions/print/main.js')}}"></script>

    <script>
        var rupiah = Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        });
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            var tablebody = '';
            $.each(d.data_barang, function (index, value) {
                tablebody+= '<tr>' +
                                '<td>' + value.nama_barang + '</td>' +
                                '<td>' + rupiah.format(value.harga_barang) + '</td>' +
                                '<td>' + value.jumlah_barang/value.harga_barang + '</td>' +
                                '<td>' + value.satuan_barang + '</td>' +
                                '<td>' + rupiah.format((value.jumlah_barang/value.harga_barang)*value.harga_barang) + '</td>' +
                            '</tr>'
            });
            return (
                '<div class="table-responsive">' +
                    '<table class="table table-bordered display">' +
                        '<thead class="thead-light">' +
                                '<tr>' +
                                    '<th scope="col" class="sort" data-sort="name">Keterangan</th>' +
                                    '<th scope="col" class="sort" data-sort="budget">Harga</th>' +
                                    '<th scope="col" class="sort" data-sort="status">Qty</th>' +
                                    '<th scope="col" class="sort" data-sort="status">Satuan</th>' +
                                    '<th scope="col" class="sort" data-sort="status">Total</th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody id="bodyChild">' +
                                 tablebody +
                            '</tbody>' +
                            '<tfoot>' +
                                '<tr>' +
                                    '<th colspan="4"style="text-align:right">Sub Total :</th>' +
                                    '<th>' + d.data_sum + '</th>' +
                                '</tr>' +
                                '<tr>' +
                                    '<th colspan="4"  style="text-align:right">Down Payment :</th>' +
                                    '<th>' + d.data_dp + '</th>' +
                                '</tr>' +
                                '<tr>' +
                                    '<th colspan="4" style="text-align:right">Discount :</th>' +
                                    '<th>' + d.data_disc + '</th>' +
                                '</tr>' +
                                '<tr>' +
                                    '<th colspan="4" style="text-align:right">Total :</th>' +
                                    '<th>' + d.data_total + '</th>' +
                                '</tr>' +
                            '</tfoot>' +
                    '</table>' +
                '</div>'
            );
        }

        $(document).ready(function () {
            var invoicetable = $('#invoiceTable').DataTable({
                "autoWidth": false,
                'ajax': {
                        'headers': {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        'type': "GET",
                        'url': "/datainvoice/list",
                        'dataSrc': function (response) {
                            return response;
                        },
                    },
                'columns' : [
                    {
                        className: 'dt-control',
                        orderable: false,
                        data: null,
                        defaultContent: '',
                        width: "5%"
                    },
                    {'data' : 'nomer_inv'},
                    {'data' : 'nama_pelanggan',},
                    {'data' : 'alamat_pelanggan'},
                ],
                order: [[1, 'asc']],
                "oLanguage": {
                        "oPaginate": {
                            "sPrevious": "<<", // This is the link to the previous page
                            "sNext": ">>", // This is the link to the next page
                    }
                }
            })

            $('#invoiceTable tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = invoicetable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data()),'no-padding').show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
@endpush
