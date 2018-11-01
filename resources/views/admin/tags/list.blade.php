@extends('layouts.admin')
@section('content')
	<button type="" class="btn btn-sm btn-primary" data-toggle="modal" href="#modal-add">Add</button>
<table class="table table-hover w-100" id="Tags">
	<thead>
		<tr>
			<th class="text-center">ID</th>
			<th class="text-center">Name</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
</table>
<div class="modal fade" id="modal-add">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="add-new" method="POST" role="form">
				<div class="modal-header">
					<h4 class="modal-title">Add Tag</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="tag-add" placeholder="Name...">
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
				<h4 class="modal-title">Detail tag</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">	
				<h3></h3>
			</div>	
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="edit-tag" method="POST" role="form">
				<div class="modal-header">
					<h4 class="modal-title">Edit Tag</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="tag-id">
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" class="form-control" id="name-edit">
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
			title: "Bạn muốn xóa tag này không?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					type:'delete',
					url:'/admin/tags/'+id,
					success: function(response){
						btn.parents('tr').remove()
						// alert(response.message)
						toastr.success(response.message)
					}
				});
			} 
		});
	});
	$(function() {
		$('#Tags').DataTable({
			processing: true,
			serverSide: true,
			ajax: '/admin/listtags',
			columns: [
				{data: 'id', name: 'id' },
				{data: 'name', name: 'name'},
				{data: 'action', name:'action'}
			]
		});
	});
	$('#add-new').submit(function(e){
		e.preventDefault();
		var name=$('#tag-add').val();
		var slug=name.replace(/ /g, '-');
		$.ajax({
			type: 'post',
			url:'/admin/tags',
			data:{
				name:$('#tag-add').val(),
				slug: slug,
			},
			success:function(response){
				toastr.success('Thêm mới thành công!')
				$('#modal-add').modal('hide')
				$('#tag-add').val('')
				console.log(response)
				var temp=`<tr role='row' class='evem'>
				<td>`+response.id+`</td>
				<td>`+response.name+`</td>
				<td>
					<button type="" class="btn btn-sm btn-info fa fa-eye" data-toggle="modal" href="#modal-show" data-id="`+response.id+`"></button><button type="" class="btn btn-sm btn-warning btn-edit fa fa-edit text-white" data-toggle="modal" href="#modal-edit" data-id="`+response.id+`"></button>

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
			url:'/admin/tags/'+id,
			success: function(response){
				$('h3').text(response.name)
			}
		})
	})
	$('table').on('click','.btn-warning',function(){
		var btn = $(this);
		var id=btn.data('id');
		$.ajax({
			type:'get',
			url:'/admin/tags/'+id+'/edit',
			success: function(response){
				$('#name-edit').val(response.name)
				$('#tag-id').val(id)
			}
		})
	})
	$('#edit-tag').submit(function(e){
		e.preventDefault()
		var id=$('#tag-id').val();
		var name=$('#name-edit').val();
		var slug=name.replace(/ /g, '-');
		$.ajax({
			type: 'put',
			url:'/admin/tags/'+id,
			data:{
				name:$('#name-edit').val(),
				slug: slug,
			},
			success:function(response){
				$('#modal-edit').modal('hide')
					toastr.success('Chỉnh sửa thành công')
					//toastr.success('Edit Successfull!')
					//alert($('#'+id).parents('tr'))
					var temp=`<tr>
					<td>`+response.id+`</td>
					<td>`+response.name+`</td>
					<td>
					<button type="" class="btn btn-sm btn-info fa fa-eye" data-toggle="modal" href="#modal-show" data-id="`+response.id+`" id="`+response.id+`"></button>
					<button type="" class="btn btn-sm btn-warning btn-edit fa fa-edit text-white" data-toggle="modal" href="#modal-edit" data-id="`+response.id+`"></button>
					<button data-id="`+response.id+`" class="btn btn-danger fa fa-trash-alt"></button>'
					</td>
					</tr>`
					$('#'+id).parents('tr').replaceWith(temp)
				}
			})
	})
</script>
@endsection