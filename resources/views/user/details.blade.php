{{-- kế thừa từ trang master --}}
@extends('layouts.master') 
{{-- thay đổi nội dung phần content --}}
@section('content')
	{{-- expr --}}
	<div class="content col-xs-8">
        	<!-- ARTICLE 1 -->
        	<article>
            	<div class="post-image">
            	<img src="{{$post->thumbnail}}" alt="post image 1"> 
            </div>
            <div class="post-text">
                <h2>{{$post->title}}</h2>
            </div>
            <div class="post-text text-content">
                <p>{{$post->content}}</p>	
            </div> 
       	 </article> 
    </div>
@endsection