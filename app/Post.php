<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts'; // bảng posts trong database
    protected $fillable = [
    		'title', 
    		'thumbnail', 
    		'description', 
    		'content',
    		'slug',
    		'user_id',
    		'category_id',
    		'view_count'
    	];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function tags(){
        return $this->belongsToMany('App\Tag','post_tags','post_id','tag_id');
    }
    public static function store($data){
        $post = new Post;
        $post->title=$data['title'];
        $post->description=$data['description'];
        $post->content=$data['content'];
        $post->slug=implode("-", explode(" ",  $data['title']));
        $path=$data['image']->store('images');
        $post->thumbnail=$path;
        $post->view_count=0;
        $post->category_id=$data['categories'];
        $post->user_id=11;
        $post->save();
        return $post;
    }
    public static function updateData($id,$data){
        $post=Post::find($id);
        // dd($data);
        $post->title=$data['title'];
        $post->description=$data['description'];
        $post->content=$data['content'];
        $post->slug=implode("-", explode(" ",  $data['title']));
        if (isset($data['image'])) {
            $path=$data['image']->store('images');
            $post->thumbnail=$path;
        }
        // $path=$data['image']->store('images');
        // $post->thumbnail=$path;
        // $post->view_count=0;
        $post->category_id=$data['categories'];
        // $post->user_id=11;
        $post->save();
        return $post;
    }
}
