<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['name', 'slug'];
    public static function store($data){
    	$tag = new Tag;
    	$tag->name=$data['name'];
    	$tag->slug=$data['slug'];
    	$tag->save();
    	return $tag;
    }
    public static function updateData($id,$data){
    	$tag= Tag::find($id);
    	$tag->name=$data['name'];
    	$tag->slug=$data['slug'];
    	$tag->save();
    	return $tag;
    }
    public function posts(){
        return $this->belongsToMany('App\Post','post_tags','tag_id','post_id');
    }
    // public function search($name){
    //     $tag=Tag::Where('name','like',$name);
    //     return $tag;
    // }
}
