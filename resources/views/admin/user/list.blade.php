<?php ?>
@extends('admin.layout.index')

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
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Manager User
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        @if (session('message'))
                            <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p>{{ session('message') }}</p>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Only see</th>
                                        <th>Delete blog</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                    <tr class="odd gradeX">
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><input type="checkbox" value="{{ $user->can_see }}" @if (!empty($user->can_see)) checked="checked" @endif></td>
                                        <td><input type="checkbox" value="{{ $user->can_delete }}" @if (!empty($user->can_delete)) checked="checked" @endif></td>
                                        <td class="center"><a href="/admin/user/edit/{{ $user->id }}">Edit</a></td>
                                        <td class="center">
                                            <input type="hidden" class="hiddenID" value="{{ $user->id }}">
                                            <a href="#" class="btnDel" data-toggle="modal" data-target="#myModal{{ $user->id }}">
                                                Delete
                                            </a>
                                        </td>
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" id="myModalLabel">Delete account</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete <b>{{ $user->name }}</b> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" data-casetype="user" class="btn btn-primary btnConf">Yes</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links() }}
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->
@endsection