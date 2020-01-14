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
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td>1</td>
                                        <td>Phan Quoc Tuan</td>
                                        <td>tuanpq@lifull-tech.vn</td>
                                        <td class="center">123456</td>
                                        <td class="center"><a href="">Edit</a></td>
                                        <td class="center"><a href="">Delete</a></td>
                                    </tr>
                                    <tr class="even gradeC">
                                        <td>2</td>
                                        <td>Nguyen Tien Thinh</td>
                                        <td>Thinhnt@lifull-tech.vn</td>
                                        <td class="center">123456</td>
                                        <td class="center"><a href="">Edit</a></td>
                                        <td class="center"><a href="">Delete</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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