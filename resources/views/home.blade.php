@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <ul class="list-group">
                            <a class="list-group-item" href="{{ url('/blogs') }}">Blogs <span class="badge badge-success">{{ $blogCount }}</span></a>
                            @if(Auth::user()->user_type->id == \App\Http\Constants\UserTypeEnum::admin || Auth::user()->user_type->id == \App\Http\Constants\UserTypeEnum::supervisor)
                                <a class="list-group-item" href="{{ url('/users') }}">Manage Users <span class="badge badge-success">{{ $userCount }}</span></a>
                            @endif
                        </ul>
                        @if(Auth::user()->user_type->id == \App\Http\Constants\UserTypeEnum::admin)
                            <div class="m-2">
                                <h2 class="text-center">User Stats</h2>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td>User Type</td>
                                        <td>Count</td>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($userStats as $userType)
                                        <tr>
                                            <td>{{$userType->name}}</td>
                                            <td>{{$userType->users_count}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <p class="text-center">My User Details</p>
                        <div class="m-2">
                            <p><b>Name:</b> {{Auth::user()->name}}</p>
                            <p><b>Last Name:</b> {{Auth::user()->last_name}}</p>
                            <p><b>Email:</b> {{Auth::user()->email}}</p>
                            @if(Auth::user()->user_boss)
                                <p><b>User Boss:</b> {{Auth::user()->user_boss->name. ' '. Auth::user()->user_boss->last_name}}</p>
                            @endif
                            <button class="btn btn-secondary"> Update Profile</button>
                        </div>
                        <small>Last login at: {{date('d-M-y h:i:s a', strtotime(Auth::user()->last_login))}}</small>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
