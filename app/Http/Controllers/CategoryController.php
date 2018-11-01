<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Yajra\Datatables\Datatables;
use App\Post;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.list');
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
       
        $category=Category::store($request->all());
        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category=Category::find($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Category::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['slug'] = str_slug($data['name']);
        $category=Category::updateData($id,$data);
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        $posts=Post::where('category_id',$id)->get();
        foreach ($posts as $post) {
            Post::find($post->id)->delete();
        }
        return response()->json([
            'message'=>'Xóa thành công',
            'error'=>false
        ]);
    }
    public function getdata()
    {
        return Datatables::of(Category::query())
            ->editColumn('thumbnail', function ($category) {
                if ($category->thumbnail==null) {
                    return "";
                }
                else if (strpos($category->thumbnail,"https://")===false) {
                    return '<img src="'. asset(\Storage::url($category->thumbnail)) .'"style="width:150px; height=100px;">';
                }else{
                return '<img src="'.$category->thumbnail.'" alt="" style="width: 150px;height: 100px;">';}
            })
            ->addColumn('action', function ($category) {
                return '<button type="" class="btn btn-sm btn-info fa fa-eye" data-toggle="modal" href="#modal-show" data-id="'.$category->id.'" id="'.$category->id.'"></button><button type="" class="btn btn-sm btn-warning btn-edit fa fa-edit text-white" data-toggle="modal" href="#modal-edit" data-id="'.$category->id.'"></button>

                    <button data-id="'.$category->id.'" class="btn btn-danger fa fa-trash-alt"></button>';
            })
            ->rawColumns(['thumbnail','action'])
            ->make(true);
    }
}
