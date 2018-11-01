<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=\App\Post::simplePaginate(5);
        return view('user.index',['posts'=>$posts]);
    }
    public function dashboard(){
        return view('admin.index');
    }
    public function search(Request $request){
        $q= $request->search;
        $posts=Post::Where('title','like','%'.$q.'%')
            ->orwhere('description','like','%'.$q.'%')
            ->orwhere('content','like','%'.$q.'%')
            ->paginate(5);
        return view('user.searchs',['posts'=>$posts, 'q' => $q]);
    }
    public function contact(){
        return view('user.contact');
    }
    public function postshow($slug)
    {
        $post = Post::where('slug', $slug)->first(); // lấy một bài viết
        return view('user.details', compact('post'));
    }
    public function categoryshow($slug){
        $category=\App\Category::Where('slug',$slug)->first();
        $posts=$category->posts;
        return view('user.posts',['posts' => $posts]);
    }
    public function userpostshow($name){
        $user=\App\User::where('name', $name)->first();
        $posts=$user->posts;
        return view('user.posts',['posts' => $posts]);
    }
    public function tagshow($slug){
        $tag=\App\Tag::where('slug',$slug)->first();
        $posts=$tag->posts;
        return view('user.posts',['posts' => $posts]);
    }
}
