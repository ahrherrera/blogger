<?php

namespace App\Http\Controllers;

use App\Http\Constants\UserTypeEnum;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('userType')->withCount('usersBossList');

        if(Auth::user()->user_type->id == UserTypeEnum::supervisor){
            $users->where('boss_id', Auth::user()->id);
        }else {
            $users->withTrashed();
        }

        $users = $users->paginate(20);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    public function edit($id)
    {
        $user = User::with('userType')->find($id);
        $userTypes = UserType::all();
        $userBoss = User::where('user_type', UserTypeEnum::supervisor)->get();
        return view('users.edit', compact('user', 'userTypes', 'userBoss'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'last_name'=> 'required',
            'user_type'=> 'required',
        ]);
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();

        return redirect('/users')->with('success', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $active = $request->get('active');
        $active = isset($active) ? $request->get('active') : 0;
        $user = User::withTrashed()->find($id);
        $user->updated_at = Carbon::now()->toDateTimeString();
        if($active == 0){
            $user->delete();
        }else {
            $user->restore();
        }

        return redirect('/users')->with('success', 'User has been updated');
    }
}
