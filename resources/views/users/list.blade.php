@extends('layouts.app', ['activePage' => 'usermanager', 'titlePage' => __('Data User')])

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
                        <h3 class="mb--1 col-7">Data User</h3>
                        <div class="col-5">
                            <button type="button" class="btn btn-sm btn-primary float-right mb-1 mr--2" data-toggle="modal" data-target="#modalUser">Tambah User</button>
                        </div>
                    </div>
                </div>
                <!-- Light table -->
                <div class="table-responsive p-3 mt--3">
                    <table class="table table-bordered display" id="datauser">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Nama User</th>
                                <th scope="col" class="sort" data-sort="budget">Email</th>
                                <th scope="col" class="sort" data-sort="status">Jabatan</th>
                                <th scope="col" class="sort" data-sort="completion">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth')
</div>

    {{-- Modal tambah barang --}}
    <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-labelledby="modalUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header bg-light">
              <h5 class="modal-title" id="exampleModalLongTitle">Tambah User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body bg-white">
                <form id="form">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary tbhUser">Tambah User</button>
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
        $(document).ready(function () {
            var rupiah = Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            });

            var tableuser = $('#datauser').DataTable({
                "autoWidth": false,
                'ajax': {
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    'type': "GET",
                    'url': "/datauser/list",
                    'dataSrc': function (response) {
                        return response;
                    },
                },
                'columns' : [
                    {'data' : 'nama'},
                    {'data' : 'email'},
                    {'data' : 'jabatan'},
                    {
                        'data'  : null ,
                        render  : function(data, type, row, meta) {
                            return  '\<button type="button" class="btn btn-sm btn-danger" id="btnDelete" data-deleteid='+row.id+'>Delete</button>';
                        }
                    }
                ],
                columnDefs: [
                    {
                        targets: 3,
                        width: "5%",
                    },
                ],
                "oLanguage": {
                        "oPaginate": {
                            "sPrevious": "<<", // This is the link to the previous page
                            "sNext": ">>", // This is the link to the next page
                    }
                }
            })

            $('.tbhUser').on('click', function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let form = $('#form')[0]
                let data = new FormData(form)
                $.ajax({
                    type: "POST",
                    url: "/datauser/register",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (response) {
                        if(response == 'success'){
                            $('#modalUser').modal('hide');
                            Swal.fire(
                                'Berhasil!',
                                'User sudah di input!',
                                'success'
                            )
                            $('#datauser').DataTable().ajax.reload();
                            $('#modalUser #form').trigger("reset");
                        }
                    },
                    error: function(response){
                        console.log(response)
                    }
                });
            });

            $('body').on('click', '#btnDelete', function(){
                let id = $(this).data('deleteid')
                Swal.fire({
                    title: 'Are you sure?',
                    text:  "User Akan Di Hapus",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    showLoaderOnConfirm: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    $.ajax({
                        type: "POST",
                        url: "datauser/delete",
                        data: {id : id},
                        success: function (response) {
                        if(response == 'success'){
                            $('#modalUser').modal('hide');
                            Swal.fire(
                                'Berhasil!',
                                'User Berhasil di hapus!',
                                'success'
                            )
                            $('#datauser').DataTable().ajax.reload();
                            $('#modalUser #form').trigger("reset");
                        }
                        },
                        error: function(response){
                            console.log(response)
                        }
                    });
                    }
                })
            });

        });
    </script>
@endpush
