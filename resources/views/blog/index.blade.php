@extends('admin.layout.index')
@section('content')
<div id="page-wrapper">
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
    </div>

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
                <th scope="col">Title</th>
                <th scope="col">Action</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($blogs as $blog)
                    <tr>
                        <td scope="row">{{$blog->id}}</td>
                        <td>{{$blog->title}}</td>
                        <td>
                            <form action="{{route('blog.edit', ['id' => $blog->id])}}" name="form-edit" method="GET">
                                <button type="submit" class="btn btn-info">Edit</button>
                            </form>
                        </td>
                        <td>
                            @if($canDelete === true)
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$blog->id}}">Delete</button>
                                <form action="{{route('blog.destroy',['id' => $blog->id])}}" name="form-edit" method="GET">
                                <!-- Modal -->
                                    <div class="modal fade" id="deleteModal{{$blog->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Warning</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Delete this blog?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

@endsection