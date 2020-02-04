<?php ?>
@extends('admin.layout.index')
@section('content')

<div id="page-wrapper">
    <form action="{{route('blog.update', ['id' => $blog->id])}}" method="POST" name="blog-edit">
        @csrf
        <div class="form-group">
            <label for="blog-title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title input" value="{{$blog->title}}">
        </div>
        <div class="form-group">
            <label for="blog-content">Content</label>
            <textarea type="text" class="ckeditor" name="content" placeholder="Content input">{{$blog->content}}
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection