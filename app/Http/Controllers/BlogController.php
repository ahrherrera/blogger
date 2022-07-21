<?php

namespace App\Http\Controllers;

use App\Common\FindExpression;
use App\Http\Constants\UserTypeEnum;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Base\Controller;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Blogs with dependencies
        $blogs = Blog::query()
            ->with(['userCreated', 'userUpdated'])->withTrashed();
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
                break;
        }
        // Paginating 20 results per page
        $blogs = $blogs->paginate(20);

        return view('blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'content'=> 'required',
        ]);
        $share = new Blog();
        $share->fill($request->all());
        $share->created_by = Auth::user()->id;
        $share->save();

        return redirect('/blogs')->with('success', 'Blog has been saved');
    }


    public function show(Blog $blog)
    {
        //
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'content'=> 'required',
        ]);

        $blog = Blog::find($id);
        $blog->fill($request);
        $blog->updated_by = Auth::user()->id;
        $blog->save();

        return redirect('/blogs')->with('success', 'Blog has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->updated_by = Auth::user()->id;
        $blog->delete();
        return redirect('/blogs')->with('success', 'Blog has been deleted');
    }

    public function search(Request $request) {
        $search = $request->input('search');
        $blogs = Blog::query()
            ->with(['userCreated', 'userUpdated'])
            ->withTrashed()
            ->where(function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
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
                break;
        }
        $blogs = $blogs->paginate(20);
        return view('blogs.index', compact('blogs'));
    }
}
