<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['parent_id', 'thumbnail', 'slug', 'description'];
    public static function store($data){
    	$category = new Category;
    	$category->name=$data['name'];
        $category->description=$data['description'];
        $path=$data['image']->store('images');
    	$category->thumbnail=$path;
    	$category->slug=$data['slug'];
    	$category->save();
    	return $category;
    }
    public static function updateData($id,$data){
        $category= Category::find($id);
        $category->name=$data['name'];
        $category->description=$data['description'];
        if (isset($data['thumbnail'])) {
            $path=$data['thumbnail']->store('images');
            $category->thumbnail=$path;
        }
        $category->slug=$data['slug'];
        $category->save();
        return $category;
    }
    public function posts(){
        return $this->hasMany('App\Post');
    }
}
