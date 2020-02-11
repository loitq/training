@extends('layouts.admin')

@section('content')
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="panel-body">
                <a href="/admin/user/list" class="btn btn-primary">List user</a>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if(count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    <strong>{{$err}}</strong><br>
                                @endforeach
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                <strong>{{session('error')}}</strong>
                            </div>
                        @endif
                        @if (session('message'))
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p>{{ session('message') }}</p>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-6">
                                @if (isset($edit))
                                    <form action="/admin/user/edit/{{ $edit->id }}" method="POST" role="form">
                                @else
                                    <form action="/admin/user/create" method="POST" role="form">
                                @endif
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control" name="username" @if (isset($edit)) disabled value="{{ $edit->name }}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="email" name="email" @if (isset($edit)) disabled value="{{ $edit->email }}" @endif>
                                    </div>
                                    @if (!isset($edit))
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="form-control" type="password" name="password">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Only see blog</label>
                                        <input class="form-control" type="checkbox" name="can_see" @if (isset($edit)) @if (!empty($edit->can_see)) checked="checked" @endif @endif>
                                    </div>
                                    <div class="form-group">
                                        <label>Can delete blog</label>
                                        <input class="form-control" type="checkbox" name="can_delete" @if (isset($edit)) @if (!empty($edit->can_delete)) checked="checked" @endif @endif>
                                    </div>
                                    <button type="submit" class="btn btn-default">
                                        Submit
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
@endsection
