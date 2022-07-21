@extends('layouts.app')

@section('content')
    <div class="card m-3 p-3">
        <div class="card-header">
            Edit User
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
            <form method="post" action="{{ route('users.update', $user) }}">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" />
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name :</label>
                    <input type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" />
                </div>

                <div class="form-group">
                    <label for="user_type">User Type :</label>
                    <select class="custom-select" name="user_type">
                        @foreach($userTypes as $item)
                            <option value="{{$item->id}}" @if($user->userType->id == $item->id) selected @endif>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="boss_id">User Boss :</label>
                    <select class="custom-select" name="boss_id">
                        @foreach($userBoss as $item)
                            <option value="{{$item->id}}" @if($user->boss_id == $item->id) selected @endif>{{$item->name.' '.$item->last_name}}</option>
                        @endforeach
                    </select>
                </div>


                <a href="{{ url('/users') }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
