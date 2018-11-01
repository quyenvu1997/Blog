<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Tag;
use App\PostTag;
class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tags.list');
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
        $tag=Tag::store($request->all());
        return $tag;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag=Tag::find($id);
        return $tag;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag=Tag::find($id);
        return $tag;
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
        $tag=Tag::updateData($id,$request->all());
        return $tag;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::find($id)->delete();
        $posttags=PostTag::where('tag_id',$id)->get();
        foreach ($posttags as $posttag) {
            PostTag::find($posttag->id)->delete();
        }
        return response()->json([
            'message'=>'Xóa thành công',
            'error'=>false
        ]);
    }
    public function getdata()
    {
        return Datatables::of(Tag::query())
            ->addColumn('action', function ($tag) {
                return '<button type="" class="btn btn-sm btn-info fa fa-eye" data-toggle="modal" href="#modal-show" data-id="'.$tag->id.'" id="'.$tag->id.'"></button><button type="" class="btn btn-sm btn-warning btn-edit fa fa-edit text-white" data-toggle="modal" href="#modal-edit" data-id="'.$tag->id.'"></button>

                    <button data-id="'.$tag->id.'" class="btn btn-danger fa fa-trash-alt"></button>';
            })
            ->make(true);
    }
}
