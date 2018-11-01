@extends('layouts.admin')
@section('content')
<a href="{{ asset('admin/posts/create') }}" title=""><button type="" class="btn btn-sm btn-primary fa fa-plus fa-2x"></button></a>
<br>
<table class="table table-hover" id="Posts">
	<thead>
		<tr>
			<th class="text-center">id</th>
			<th class="text-center">title</th>
			<th class="text-center">Post by</th>
			{{-- <th class="text-center">View_count</th> --}}
			<th class="text-center">action</th>
		</tr>
	</thead>
</table>
<div class="modal fade" id="modal-show">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Detail post</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">	
				<h3></h3>
				<img src="" alt="" class="w-100">	
				<p></p>
			</div>	
		</div>
		{{-- <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div> --}}
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js" type="text/javascript"></script>
<script type="text/javascript">

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(function() {
		    $('#Posts').DataTable({
		        processing: true,
		        serverSide: true,
		        ajax: '/admin/listposts',
		        columns: [
		            { data: 'id', name: 'id' },
		            { data: 'title', name: 'title'},
		            // { data: 'thumbnail', name: 'thumbnail'},
		            // { data: 'view_count', name: 'view_count' },
		            { data: 'Post by', name:'Post by'},
		            { data: 'action', name: 'action'}
		        ]
		    });
		});
	$('table').on('click','.btn-danger',function(){
		var btn = $(this);
		var id=btn.data('id');
		swal({
			title: "Bạn muốn xóa bài viết này không?",
			// text: "Once deleted, you will not be able to recover this imaginary file!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					type:'delete',
					url:'/admin/posts/'+id,
					success: function(response){
						toastr.success(response.message)
						btn.parents('tr').remove()
					}
				});
			} 
			// else {
			// 	swal("Your imaginary file is safe!");
			// }
		});
		
	});
	$('table').on('click','.btn-info',function(){
			var btn = $(this);
			var id=btn.data('id');
			$.ajax({
				type:'get',
				url:'/admin/posts/'+id,
				success: function(response){
					$('h3').text(response.title)
					$('img').attr('src',response.thumbnail)
					$('p').text(response.content)
				}
			})
		})
	$(document).ready(function() {
		$('#Posts').DataTable();
	});
</script>
@endsection