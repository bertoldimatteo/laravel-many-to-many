@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Lista posts</h1>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{route('admin.posts.create')}}" class="btn btn-info">Crea nuovo post</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Content</th>
                        <th scope="col">Status</th>
                        <th scope="col">Modify</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->slug}}</td>
                            <td>{{substr($post->content, 0, 10)}}</td>  
                            <td>
                                @if ($post->published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                <span class="badge bg-warning text-dark">Not Published</span>
                                @endif
                            </td>
                            <td>
                                <div>
                                    <a href="{{route('admin.posts.show', $post->id)}}" class="btn btn-primary">View</a>
                                    <a href="{{route('admin.posts.edit', $post->id)}}" class="btn btn-warning">Edit</a>
                                    <form action="{{route('admin.posts.destroy', $post->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>   
    </div>
</div>         
@endsection