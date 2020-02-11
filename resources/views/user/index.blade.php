@extends('admin.layout.index')

@section('content')
<div class="container">
    @foreach ($blogs as $blog)
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $blog['userName'] }}</h3>
        </div>
        <div class="panel-body">
            <h4>{{$blog['title']}}</h4>
            {{ $blog['content'] }}
        </div>
        <div class="panel-footer">
            <a role="button" id="{{ $blog['blogId'] }}" href="#">Comment  </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
