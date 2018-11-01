{{-- kế thừa từ trang master --}}
@extends('layouts.master') 

{{-- thay đổi nội dung phần content --}}
@section('content')
	{{-- expr --}}
	<div class="content col-xs-8">
	@foreach ($posts as $post)
		<div class="col-xs-6">     
        	<article>
            	<div class="post-image">
                	<img src="{{ $post->thumbnail }}" alt="post image 1">
                    <div class="category"><a href="#">IMG</a></div>
                </div>
                <div class="post-text">
                	<span class="date">07 Jun 2016</span>
                    <h2><a href="\posts\{{$post->slug}}">{{$post->title}}</a></h2>
                    <p class="text">{{$post->description}}
                                    <a href="\posts\{{$post->slug}}"><i class="icon-arrow-right2"></i></a></p>                                 
                </div>
                <div class="post-info">
                	<div class="post-by">Post By <a href="{{ asset('users') }}\{{$post->user->id}}">{{$post->user->name}}</a></div>
                </div>
            </article>
        
       </div>
	@endforeach	
    {{-- <div class="navigation">
        <a href="{{$posts->previousPageUrl()}}" class="prev"><i class="icon-arrow-left8"></i> Previous Posts</a>
        <a href="{{$posts->nextPageUrl()}}" class="next">Next Posts <i class="icon-arrow-right8"></i></a>
        <div class="clearfix"></div>
    </div> --}}
	</div>
@endsection