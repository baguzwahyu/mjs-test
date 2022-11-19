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
                    <form action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" name="name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" name="email">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Uploads Avatar</label>
                            <input type="file" class="form-control" name="avatar">
                        </div>
                        <div class="form-group">
                            <label>Facebook Profile</label>
                            <input type="text" class="form-control" value="{{ $user->profile->facebook }}" name="facebook">
                        </div>
                        <div class="form-group">
                            <label>Youtube Profile</label>
                            <input type="text" class="form-control" value="{{ $user->profile->youtube }}" name="youtube">
                        </div>
                        <div class="form-group">
                            <label>About You</label>
                            <textarea class="form-control" id="about" cols="6" rows="6" name="about">{{ $user->profile->about }}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><span class="fa fa-send" aria-hidden="true"></span> Update Profile </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>


@endsection