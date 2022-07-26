@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>{{$post->title}}</h1>
                @if ($post->category)
                    <span class="badge badge-primary">{{$post->category->name}}</span>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{route('admin.posts.index')}}" class="btn btn-info">Tutti i Posts</a>
                </div>
                <div>
                    {{$post->content}}
                </div>    
            </div>
        </div>        
    </div>    
@endsection