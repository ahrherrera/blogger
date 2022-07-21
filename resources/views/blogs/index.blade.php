@extends('layouts.app')
@section('content')
    <div class="m-3 p-3">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif
        <h2>Blogs List</h2>
        <div class="m-2 float-right">
            <form action="{{ route('blogs.search') }}" method="GET" class="row m-2">
                <input type="text" class="form-control col-8" name="search" required/>
                <button class="btn btn-primary col-4" type="submit">Search</button>
            </form>
            <a href="{{url('/blogs/create')}}" class="btn btn-primary"> New Blog</a>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Description</td>
                <td>Created At</td>
                <td>Created By</td>
                <td>Updated By</td>
                <td colspan="2">Action</td>
            </tr>
            </thead>

            <tbody>
            @if($blogs->isNotEmpty())
            @foreach($blogs as $blog)
                <tr>
                    <td>{{$blog->id}}</td>
                    <td>{{$blog->name}}</td>
                    <td>{{$blog->description}}</td>
                    <td>{{date('d-M-y h:i a', strtotime($blog->created_at))}}</td>
                    <td>{{$blog->userCreated->name.' '. $blog->userCreated->last_name}}</td>
                    @if($blog->userUpdated)
                        <td>{{$blog->userUpdated->name.' '. $blog->userUpdated->last_name}}</td>
                    @else
                        <td>---</td>
                    @endif
                    @if($blog->deleted_at)
                        <td class="text-danger">
                            Deleted
                        </td>
                    @else
                        <td><a href="{{ route('blogs.edit', $blog->id)}}" class="btn btn-primary">Edit</a></td>
                        <td>
                            <form id="deleteFrm" action="{{ route('blogs.destroy', $blog->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
            @else
                <div>
                    <h2>No blogs found</h2>
                </div>
            @endif
            </tbody>
        </table>
            {{ $blogs->links() }}
        <div>
@endsection
