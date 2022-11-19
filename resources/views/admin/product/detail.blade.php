@extends('layouts.app')
@section('title','')
@section('content')

@include('admin.includes.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Table Detail Product</h3>
        </div>

        <div class="panel-body">
            <table id="list-product-detail" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Tanggal</th>
                        <th>Barang</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total stok</th>
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
                dataTable = $('#list-product-detail').DataTable({
                    searching: true,
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    filter: false,
                    info: false,
                    ordering:true,
                    lengthChange: true,
                    responsive: true,
                    orderable: true,
                    order: [[1, "asc"]],
                    ajax: {
                        url: "{{route('product.read_detail')}}",
                        type: "GET",
                        data: function (data) {
                            data.product_id = {{$product->id}};
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
                    ],
                    columns: [
                        { data: "no" },
                        { data: "transaction_no" },
                        { data: "date" },
                        { data: "name" },
                        { data: "type" },
                        { data: "price" },
                        { data: "amount" },
                        { data: "total_stock" },
                    ]
                });
            });
        });
    </script>
@endpush