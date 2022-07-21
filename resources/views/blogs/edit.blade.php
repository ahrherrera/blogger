@extends('layouts.app')

@section('content')
    <div class="card m-3 p-3">
        <div class="card-header">
            Edit Blog
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('blogs.update', $blog->id) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ $blog->name }}" />
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <input type="text" class="form-control" name="description" value="{{ $blog->description }}" />
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea rows="5" class="form-control" name="content">{{ $blog->content }}</textarea>

                </div>
                <a href="{{ url('/blogs') }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
