@extends('layouts.admin')
@section('content')
<button type="" class="btn btn-sm btn-primary" data-toggle="modal" href="#modal-add">Add</button>
<table class="table table-hover" id="Categories">
	<thead>
		<tr>
			<th class="text-center">ID</th>
			<th class="text-center">Name</th>
			<th class="text-center">Thumbnail</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
</table>
<div class="modal fade" id="modal-add">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="add-new" method="POST" role="form" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title">Add Category</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name-add" placeholder="Name...">
					</div>
					<div class="p-2" style="font-size: 18px;">
						<canvas id= "review"  class="border border-muted w-100" style="height: 270px;">
						</canvas>
						<p>
							<input type = "file" multiple ="false" accept = "image/*" id = "image" onchange = "Upload()" name="thumbnail" id="thumbnail-add">
						</p>      
					</div>
					<div class="form-group">
						<label for="">Description</label>
						<textarea name="description-add" class="form-control" rows="5" placeholder="Description..." id="description-add"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" >Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-show">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail category</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">	
				<h3 id="show-name"></h3>
				<img id="show-thumbnail" src="" alt="" class="w-100">	
				<p id="show-description"></p>
			</div>	
		</div>
		{{-- <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div> --}}
	</div>
</div>
<div class="modal fade" id="modal-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="edit-category" method="POST" role="form" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title">Edit Category</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="category-id">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name-edit" name="name">
					</div>
					<div class="p-2" style="font-size: 18px;">
						<canvas id= "review-edit"  class="border border-muted w-100" style="height: 270px;">
						</canvas>
						<p>
							<input type = "file" multiple ="false" accept = "image/*" id = "image-edit" onchange = "EditUpload()" name="thumbnail" >
						</p>      
					</div>
					<div class="form-group">
						<label for="">Description</label>
						<textarea name="description" class="form-control" rows="5" id="description-edit"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js" type="text/javascript"></script>
<script src="https://www.dukelearntoprogram.com/course1/common/js/image/SimpleImage.js"></script>
<script type="text/javascript">
	$('table').on('click','.btn-danger',function(){
		var btn = $(this);
		var id=btn.data('id');
		swal({
			title: "Bạn muốn xóa bài viết này không?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					type:'delete',
					url:'/admin/categories/'+id,
					success: function(response){
						btn.parents('tr').remove()
						toastr.success(response.message)
					}
				});
			} 
		});
	});
	$(function() {
		$('#Categories').DataTable({
			processing: true,
			serverSide: true,
			ajax: '/admin/listcategories',
			columns: [
				{data: 'id', name: 'id' },
				{data: 'name', name: 'name'},
				{data: 'thumbnail', name: 'thumbnail'},
				{data: 'action', name: 'action'}
			]
		});
	});
	$('#add-new').submit(function(e){
		e.preventDefault();
		var name=$('#name-add').val();
		var slug=name.replace(/ /g, '-');
		var formData= new FormData();
		formData.append('name',$('#name-add').val());
		formData.append('description',$('#description-add').val());
		formData.append('slug',slug);
		formData.append('image',$('#image')[0].files[0]);
		$.ajax({
			type: 'post',
			url:'/admin/categories',
			data:formData,
			processData:false,
			contentType:false,
			success:function(response){
				toastr.success('Add Successfull!')
				$('#modal-add').modal('hide')
				$('#category-add').val('')
				$('#description-add').val('')
				console.log(response)
				var temp=`<tr role='row' class='even'>
				<td>`+response.id+`</td>
				<td>`+response.name+`</td>
				<td> <img src="asset(\Storage::url(`+response.thumbnail+`)) "style="width:50px; height=50px;">
				</td>
				<td>
				<button type="" class="btn btn-sm btn-info fa fa-eye" data-toggle="modal" href="#modal-show" data-id="`+response.id+`" id="`+response.id+`"></button>
				<button type="" class="btn btn-sm btn-warning btn-edit fa fa-edit text-white" data-toggle="modal" href="#modal-edit" data-id="`+response.id+`"></button>
				<button data-id="`+response.id+`" class="btn btn-danger fa fa-trash-alt"></button>

				</td>
				</tr>`
				$('tbody').append(temp)
			}
		})
	})
	$('table').on('click','.btn-info',function(){
		var btn = $(this);
		var id=btn.data('id');
		$.ajax({
			type:'get',
			url:'/admin/categories/'+id,
			success: function(response){
				$('#show-name').text(response.name)
				$('#show-thumbnail').attr('src',response.thumbnail)
				$('#show-description').text(response.description)
			}
		})
	})
	$('table').on('click','.btn-warning',function(){
		var btn = $(this);
		var id=btn.data('id');
		$.ajax({
			type:'get',
			url:'/admin/categories/'+id+'/edit',
			success: function(response){
				$('#name-edit').val(response.name)
				$('#description-edit').text(response.description)
				$('#category-id').val(id)
			}
		})
	})
	$('#edit-category').submit(function(e){
		e.preventDefault()
		var id=$('#category-id').val();
		// var name=$('#name-edit').val();
		// var slug=name.replace(/ /g, '-');
		// var description=$('#description-edit').val();
		var formData= new FormData();
		formData.append('name',$('#name-edit').val());
		formData.append('description',$('#description-edit').val());
		// formData.append('slug',slug);
		formData.append('thumbnail',$('#image-edit')[0].files[0]);
		// console.log(formData);

		// var formData = $('#edit-category').serialize();
		$.ajax({
			type: 'post',
			url:'/admin/categories/update/'+id,
			data:formData,processData: false, contentType: false,
			// dataType: 'json',
			success:function(response){
				$('#modal-edit').modal('hide')
					// toastr.success('Success')
					toastr.success('Edit Successfull!')
					console.log(response)
					var temp=`<tr role='row' class='even'>
					<td>`+response.id+`</td>
					<td>`+response.name+`</td>
					<td> @if (strpos(`+response.thumbnail+`,"https://")!==false)
					<img src="'. asset(\Storage::url(`+response.thumbnail+`)) .'"style="width:150px; height=100px;">
					@else
					<img src="`+response.thumbnail+`" alt="" style="width: 150px;height: 100px;">
					@endif
					</td>
					<td>
					<button type="" class="btn btn-sm btn-info fa fa-eye" data-toggle="modal" href="#modal-show" data-id="`+response.id+`" id="`+response.id+`"></button>
					<button type="" class="btn btn-sm btn-warning btn-edit fa fa-edit text-white" data-toggle="modal" href="#modal-edit" data-id="`+response.id+`"></button>
					<button data-id="`+response.id+`" class="btn btn-danger fa fa-trash-alt"></button>
					</td>
					</tr>`
				$('#'+id).parents('tr').replaceWith(temp)
			}
		})
	})
	function Upload() {
		var cc1 = document.getElementById("review");
		var fileinput = document.getElementById("image");
		var image = new SimpleImage(fileinput);
		image.drawTo(cc1);
	}
	function EditUpload() {
		var cc1 = document.getElementById("review-edit");
		var fileinput = document.getElementById("image-edit");
		var image = new SimpleImage(fileinput);
		image.drawTo(cc1);
	}
</script>
@endsection
