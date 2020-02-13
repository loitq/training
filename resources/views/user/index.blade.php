@extends('layouts.user')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    @foreach ($blogs as $blog)
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $blog['user']['name'] }}</h3>
        </div>
        <div class="panel-body">
            <h4>{{$blog['title']}}</h4>
            {{ $blog['content'] }}
        </div>
        <div class="panel-footer">
            <a class="view-comment" role="button" id="{{ $blog['id'] }}">Comment</a>
            <div id="list-comment-{{$blog['id']}}"></div>
            <div id="send-comment-{{$blog['id']}}"></div>
        </div>
    </div>
    @endforeach
    {{$blogs->links()}}
</div>
@endsection
