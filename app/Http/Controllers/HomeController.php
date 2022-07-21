<?php

namespace App\Http\Controllers;

use App\Http\Constants\UserTypeEnum;
use App\Models\Blog;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blogs = Blog::query()
            ->with(['userCreated', 'userUpdated'])->withTrashed();
        $users = User::query();
        // Get Current user type
        $currentUserType = Auth::user()->user_type->id;

        // Filter depending the user type
        switch ($currentUserType) {
            case UserTypeEnum::blogger:
                $blogs->where('created_by', Auth::user()->id)
                    ->whereNull('deleted_at');
                break;
            case UserTypeEnum::supervisor:
                $blogs->whereHas('userCreated', function ($query) {
                    $query->where('boss_id',Auth::user()->id);
                })->orWhere('created_by', Auth::user()->id);
                $users->where('boss_id', Auth::user()->id);
                break;
        }

        $userStats = UserType::query()->withCount('users')->get();

        $blogCount = $blogs->count();
        $userCount = $users->count();
        return view('home', compact('blogCount', 'userCount', 'userStats'));
    }
}
