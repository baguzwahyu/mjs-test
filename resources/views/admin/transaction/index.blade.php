@extends('layouts.app')
@section('title','')
@section('content')

@include('admin.includes.errors')
<div class="x_panel">
        <div class="x_title">
            <h2>Table Transaksi</h2>
            <div class="nav navbar-right panel_toolbox" style="margin-right: -25px;">
            <a href="{{route('transaction.create')}}" class="btn btn-success btn-sm text-white" title="Tambah">
                <i class="fa fa-plus"></i>
            </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <table id="list-transaction" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
             $('.delete-confirm').on('click', function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                swal({
                    title: 'Are you sure?',
                    text: 'This record and it`s details will be permanantly deleted!',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                    }).then(function(value) {
                    if (value) {
                    window.location.href = url;
                    }
                });
            });
            $(function () {
                dataTable = $('#list-transaction').DataTable({
                    searching: true,
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    filter: false,
                    info: false,
                    lengthChange: true,
                    responsive: true,
                    order: [[1, "asc"]],
                    ajax: {
                        url: "{{route('transaction.read')}}",
                        type: "GET",
                        data: function (data) {
                        }
                    },
                    columnDefs: [
                        { className: "text-center", targets: [0, 3] },
                        {
                            render: function ( data, type, row ) {
                                if(row.type == 1){
                                    return `<span class="label label-success">${row.type_name}</span>`
                                }
                                else{
                                    return `<span class="label label-danger">${row.type_name}</span>`
                                }
                            },
                            targets: [4]
                        },
                        {
                            render: function (data, type, row) {
                                return `
                                    <a href="{{url('admin/transaction/edit')}}/${row.id}"><i class="fa fa-pencil mr-2"></i></a>
                                    <a href="{{url('admin/transaction/destroy')}}/${row.id}" class="delete-confirm"><i class="delete-confirm fa fa-trash mr-2"></i></a>
                                `
                            }, targets: [7]
                        }
                    ],
                    columns: [
                        { data: "no" },
                        { data: "transaction_no" },
                        { data: "date" },
                        { data: "name" },
                        { data: "type" },
                        { data: "price" },
                        { data: "amount" },
                        { data: "id" },
                    ]
                });
            });
        });
    </script>
@endpush