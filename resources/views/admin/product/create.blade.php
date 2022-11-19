@extends('layouts.app')
@section('title','')
@section('content')

@include('admin.includes.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Buat Produk</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <form action="{{route('product.store')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" class="form-control" name="price">
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" class="form-control" name="stock">
                        </div>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-send" aria-hidden="true"></span> Submit</button>
                    </form>
                </div>
            </div>
        </div>
</div>


@endsection