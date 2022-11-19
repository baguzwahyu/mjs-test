@extends('layouts.app')
@section('title','Users')
@section('content')

    @include('admin.includes.errors')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Users</h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="{{route('user.store')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>user</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><span class="fa fa-send" aria-hidden="true"></span> Simpan </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>


@endsection