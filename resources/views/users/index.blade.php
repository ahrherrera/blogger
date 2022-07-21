@extends('layouts.app')
@section('content')
    <div class="m-3 p-3">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br/>
        @endif
        <h2>Users List</h2>
        <div class="m-2 float-right">
{{--            <form action="{{ route('users.search') }}" method="GET" class="row m-2">--}}
{{--                <input type="text" class="form-control col-8" name="search" required/>--}}
{{--                <button class="btn btn-primary col-4" type="submit">Search</button>--}}
{{--            </form>--}}
{{--            <a href="{{url('/blogs/create')}}" class="btn btn-primary"> New Blog</a>--}}
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Last Name</td>
                <td>Updated At</td>
                <td>Last Login</td>
                <td>User Type</td>
                <td>Users Boss</td>
                <td colspan="2">Action</td>
            </tr>
            </thead>

            <tbody>
            @if($users->isNotEmpty())
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{date('d-M-y h:i a', strtotime($user->updated_at))}}</td>
                        <td>{{date('d-M-y h:i a', strtotime($user->last_login))}}</td>
                        <td>{{$user->userType->name}}</td>
                        @if($user->userType->id == \App\Http\Constants\UserTypeEnum::supervisor)
                            <td>{{$user->users_boss_list_count}}</td>
                        @else
                            <td>---</td>
                        @endif
                        @if($user->deleted_at)
                            <td>
                                <form action="{{ route('users.destroy', ['id' => $user->id, 'active' => 1])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-success" type="submit">Restore</button>
                                </form>
                            </td>
                        @else
                            @if(Auth::user()->user_type->id == \App\Http\Constants\UserTypeEnum::admin)
                                <td><a href="{{ route('users.edit', $user->id)}}" class="btn btn-primary">Edit</a></td>
                                <td>
                                    <form id="deleteFrmUser" action="{{ route('users.destroy', $user->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            @endif
                        @endif
                    </tr>
                @endforeach
            @else
                <div>
                    <h2>No users found</h2>
                </div>
            @endif
            </tbody>
        </table>
            {{ $users->links() }}
        <div>
@endsection
