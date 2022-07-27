@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Lista Tag</h1>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{route('admin.tags.create')}}" class="btn btn-info">Crea un Tag</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Modify</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{$tag->id}}</td>
                            <td>{{$tag->name}}</td>
                            <td>{{$tag->slug}}</td> 
                            <td>
                                <div>
                                    <a href="{{route('admin.tags.show', $tag->id)}}" class="btn btn-primary">View</a>
                                    <a href="{{route('admin.tags.edit', $tag->id)}}" class="btn btn-warning">Edit</a>
                                    <form action="{{route('admin.tags.destroy', $tag->id)}}" method="POST">
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