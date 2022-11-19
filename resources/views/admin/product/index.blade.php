@extends('layouts.app')
@section('title','')
@section('content')

@include('admin.includes.errors')
    <div class="x_panel">
        <div class="x_title">
            <h2>Table Product</h2>
            <div class="nav navbar-right panel_toolbox" style="margin-right: -25px;">
            <a href="{{route('product.create')}}" class="btn btn-success btn-sm text-white" title="Tambah">
                <i class="fa fa-plus"></i>
            </a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table id="list-product" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stock</th>
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
                dataTable = $('#list-product').DataTable({
                    searching: true,
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    filter: false,
                    info: false,
                    lengthChange: true,
                    responsive: true,
                    order: [[4, "asc"]],
                    ajax: {
                        url: "{{route('product.read')}}",
                        type: "GET",
                        data: function (data) {
                        }
                    },
                    columnDefs: [
                        { className: "text-center", targets: [0, 3,4] },
                        {
                            render: function (data, type, row) {
                                return `
                                    <a href="{{url('admin/product/detail')}}/${row.id}"><i class="fa fa-info-circle mr-2"></i></a>
                                    <a href="{{url('admin/product/edit')}}/${row.id}"><i class="fa fa-pencil mr-2"></i></a>
                                    <a href="{{url('admin/product/destroy')}}/${row.id}" class="delete-confirm"><i class="delete-confirm fa fa-trash mr-2"></i></a>
                                `
                            }, targets: [4]
                        }
                    ],
                    columns: [
                        { data: "no" },
                        { data: "name" },
                        { data: "price" },
                        { data: "stock" },
                        { data: "id" },
                    ]
                });
            });
        });
    </script>
@endpush