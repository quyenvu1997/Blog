@extends('layouts.admin')
@section('content')
<div class="container-fluit">
	<form action="/admin/posts" method="POST" class="" role="form" enctype="multipart/form-data">
		@csrf
		<div class="row">
			<div class="col-8">
				<div class="form-group">
					<label>Title:</label>
					<input type="text" class="form-control" name="title" placeholder="Title...">
				</div>
				<div class="form-group">
					<label>Description:</label>
					{{-- <input type="text" class="form-control" name="description" placeholder="Title..."> --}}
					<textarea name="description" class="form-control" rows="7"></textarea>
				</div>
				<div class="form-group">
					<label>Content:</label>
					<textarea name="content" class="form-control" rows="20" id="content"></textarea>
					{{-- <input type="text" class="form-control" name="content" placeholder="Title..."> --}}
				</div>
			</div>
			<div class="col-4">
				<div class="rounded border border-muted">
					<div class="bg-info text-white text-center font-weight-bold rounded-top" style="font-size: 30px;">
						CATEGORIES
					</div>
					<div class="p-2" style="font-size: 20px;">
						@foreach ($categories as $category)
						<input type="checkbox" name="categories" value="{{$category->id}}">{{$category->name}}
						<br>
						@endforeach
					</div>	
				</div><br>
				<div class="rounded border border-muted">
					<div class="bg-info text-white text-center font-weight-bold rounded-top" style="font-size: 30px;">
						Thumbnail
					</div>
					<div class="p-2" style="font-size: 18px;">
						<canvas id= "can1"  class="border border-muted w-100" style="height: 228px;">
						</canvas>
						<p>
							<input type = "file" multiple ="false" accept = "image/*" id = "finput" onchange = "Upload()" name="image">
						</p>      
					</div>	
				</div><br>
				<div class="rounded border border-muted">
					<div class="bg-info text-white text-center font-weight-bold rounded-top" style="font-size: 30px;" placeholder="các tag cách nhau bởi dấu phẩy">
						Tag
					</div>
					<input type="text" name="tag" /class="form-control" placeholder="">	
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Thêm</button>
	</form>
</div>
<script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
	function Upload() {
		var cc1 = document.getElementById("can1");
		var fileinput = document.getElementById("finput");
		var image = new SimpleImage(fileinput);
		image.drawTo(cc1);
	}
	CKEDITOR.config.height = '661px';
	CKEDITOR.replace( 'content' );
</script>
@endsection