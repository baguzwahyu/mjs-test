@extends('layouts.app')
@section('title','')
@section('content')

@include('admin.includes.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Buat Transaksi</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <form action="{{route('transaction.store')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>No Transaksi</label>
                            <input type="text" class="form-control" name="" readonly placeholder="Otomatis">
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <div class="">
                                <div class="input-group">
                                    <input type="text" class="form-control date-picker" id="date" name="date" placeholder="Masukkan Tanggal" required/>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Produk</label>
                            <select name="product_id" class="form-control select2">
                                @foreach ($products as $product)
                                <option value=""></option>
                                <option value="{{ $product->id }}"> {{ $product->name }} </option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="flat" checked name="type" value="1"> Penambahan
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" class="flat" name="type" value="0"> Pengurangan
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="text" class="form-control" name="price">
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="text" class="form-control" name="amount">
                        </div>
                        <button type="submit" class="btn btn-primary"><span class="fa fa-send" aria-hidden="true"></span> Submit</button>
                    </form>
                </div>
            </div>
        </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.date-picker').on('change', function(){
			$('.datepicker').hide();
		});
		$('.date-picker').datepicker({ format: 'dd-mm-yyyy'});
        });
    </script>
@endpush