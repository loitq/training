<?php ?>
@extends('admin.layout.index')
@section('content')

<div id="page-wrapper">
    <form action="{{route('admin.blog.update', ['id' => $blog->id])}}" method="POST" name="blog-edit">
        @csrf
        <div class="form-group">
            <label for="blog-user">User</label>
            <input type="text" class="form-control" name="title" placeholder="Title input" value="{{$blog->name}}" disabled>
        </div>
        <div class="form-group">
            <label for="blog-title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title input" value="{{$blog->title}}">
        </div>
        <div class="form-group">
            <label for="blog-content">Content</label>
            <textarea type="text" class="ckeditor" name="content" placeholder="Content input">{{$blog->content}}
            </textarea>
        </div>
        <div>
            <label for="blog-created-at">Created at</label>
            <input type="datetime-local" class="form-control" name="created-at" value="{{date('Y-m-d\TH:i' ,strtotime($blog->created_at))}}" disabled>
        </div>
        <div>
            <label for="blog-updated-at">Updated at</label>
            <input type="datetime-local" class="form-control" name="updated-at" value="{{date('Y-m-d\TH:i' ,strtotime($blog->updated_at))}}" disabled>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection