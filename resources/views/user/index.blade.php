{{-- kế thừa từ trang master --}}
@extends('layouts.master') 

{{-- thay đổi nội dung phần content --}}
@section('content')

	<!-- CONTENT -->
	<div class="content col-xs-8">
    	<!-- ARTICLE  -->  
    	{{-- kiểm tra sự tồn tại của dữ liệu trước khi dùng --}}
		@if(isset($posts)) 
			{{-- in tất cả bài viết ra bằng foreach --}}
			@foreach ($posts as $post)
				
		    	<article>
		        	<div class="post-image">
		            	<img src="{{ asset($post->thumbnail) }}" alt="post image 1">
		                <div class="category"><a href="#">IMG</a></div>
		            </div>
		            <div class="post-text">
		            	<span class="date">{{ $post->created_at }}</span>
		                <h2><a href="\user\posts\{{$post->slug}}">{{ $post->title }}</a></h2>
		                <p class="text">
		                	{!! $post->description !!}
                            <a href="\user\posts\{{$post->slug}}"><i class="icon-arrow-right2"></i></a>
		                </p>                                 
		            </div>
		            <div class="post-info">
		            	<div class="post-by">Post By <a href="\user\userpost\{{$post->user->name}}">{{ $post->user->name }}</a></div>
		                <div class="extra-info">
		                	<a href="#"><i class="icon-facebook5"></i></a>
		            		<a href="#"><i class="icon-twitter4"></i></a>
		            		<a href="#"><i class="icon-google-plus"></i></a>
		                    <span class="comments">25 <i class="icon-bubble2"></i></span>
		                </div>
		                <div class="clearfix"></div>
		            </div>
		        </article>

			@endforeach
	    @endif
	    {{-- {{$posts->render()}} --}}    
    	<!-- NAVIGATION -->
    	<div class="navigation">
    		@if ($posts->currentPage()!=1)
    			<a href="{{$posts->previousPageUrl()}}" class="prev"><i class="icon-arrow-left8"></i> Previous Posts</a>
    		@endif
        	
        	@if ($posts->hasMorePages())
        		<a href="{{$posts->nextPageUrl()}}" class="next">Next Posts <i class="icon-arrow-right8"></i></a>
        	@endif
            {{-- <a href="{{$posts->nextPageUrl()}}" class="next">Next Posts <i class="icon-arrow-right8"></i></a> --}}
            <div class="clearfix"></div>
        </div>
    
    </div>
    
@endsection