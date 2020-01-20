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
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form role="form">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="email">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password">
                                    </div>
                                    <div class="form-group">
                                        <label>Only see blog</label>
                                        <input class="form-control" type="checkbox">
                                    </div>
                                    <div class="form-group">
                                        <label>Can delete blog</label>
                                        <input class="form-control" type="checkbox">
                                    </div>
                                    <button type="submit" class="btn btn-default">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-default">
                                        Reset
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