<?php ?>
@extends('layouts.app')
@section('content')

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Create Blog</button>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">New blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('blog.store')}}" name="form-create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="blog-title" class="col-form-label">Title:</label>
                        <input type="text" class="form-control" id="blog-title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="blog-content" class="col-form-label">Content:</label>
                        <textarea class="ckeditor" id="blog-content" name="content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">User ID</th>
            <th scope="col">Title</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach ($blogs as $blog)
                <tr>
                    <td scope="row">{{$blog->id}}</td>
                    <td>{{$blog->user_id}}</td>
                    <td>{{$blog->title}}</td>
                    <td>
                        <form action="" name="form-edit" method="GET">
                            <button type="submit" class="btn btn-info">Edit</button>
                        </form>
                        @if($canDelete == true)
                            <form action="" name="form-edit" method="DELETE">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tr>
    </tbody>
</table>

@endsection