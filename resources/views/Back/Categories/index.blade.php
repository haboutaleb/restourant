@extends('layouts.layout')

@section('title', 'الفئات')

@section('content')
<!-- Page length options -->
<div class="panel panel-flat">
	<div class="panel-heading">
		<h5 class="panel-title">Page length options</h5>
		<div class="heading-elements">
			<ul class="icons-list">
				<li><a data-action="collapse"></a></li>
				<li><a data-action="reload"></a></li>
				<li><a data-action="close"></a></li>
			</ul>
		</div>
	</div>

	<div class="panel-body"></div>

	<table class="table datatable-show-all" id="categories">
		<thead>
			<tr>
				<th>الاسم</th>
				<th>الوصف</th>
				<th>الصوره</th>
				<th>الفئة الرئيسية</th>
				@if(is_admin($auth->id) != 0)
				<th class="text-center">الخيارات</th>
				@endif
			</tr>
		</thead>
		<tbody>
			@forelse($categories as $category)

			<tr id="category-row-{{ $category->id }}">
				<td>{{ $category->title }}</td>
				<td>{{ $category->description }}</td>
				<td><img width="60" height="60" class="img-circle" src="{{ getImage('categories', $category->image)}}" alt=""></td>
				<td>{{ $category->parent->title }}</td>
				@if(is_admin($auth->id) != 0)
				<td class="text-center">
					<ul class="icons-list">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon-menu9"></i>
							</a>

							
							<ul class="dropdown-menu dropdown-menu-right">
								@if(is_admin($auth->id) == 2 || is_admin($auth->id) == 1)
								<li>
									<a href="{{ route('categories.edit',['id'=>$category->id]) }}"><i class="icon-database-edit2"></i>تعديل</a>
								</li>
								@endif
								@if(is_admin($auth->id) == 1)
								<li>
									<a data-id="{{ $category->id }}" class="delete-action" href="{{ url('/categories/'.$category->id) }}">
										<i class="icon-database-remove"></i>حذف
									</a>
								</li>
								@endif
							</ul>
							
						</li>
					</ul>
				</td>
				@endif
			</tr>
			@empty
			<tr>
				<td colspan="5" class="text-center"><b>No Data</b></td>
			</tr>
			@endforelse
		</tbody>
	</table>
</div>
<!-- /page length options -->
@stop

@section('script')
<script>
	$('.delete-action').on('click', function(e)
	{
		var id = $(this).data('id');
		var tbody = $('table#categories tbody');
		var count = tbody.data('count');

		e.preventDefault();

		swal({
			title: "هل انت متأكد من حذف هذه الفئة",
			text: "سيتم الحذف بالانتقال لسلة المهملات",
  			icon: "warning",
  			buttons: true,
  			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				var tbody = $('table#categories tbody');
				var count = tbody.data('count');
				
				$.ajax({
					type: 'POST',
					url: '{{ url('admin-panel/categories/ajax-delete-category') }}',
					data: {id: id},
					success: function(response)
					{
						if(response.deleteStatus)
						{
							$('#category-row-'+id).fadeOut(); count = count - 1;tbody.attr('data-count', count);
							swal(response.message, {icon: "success"});
						}
						else
						{
							swal(response.error);
						} 
					},
					error: function(x) { swal(x); },
					complete: function() { 
						if(count == 1) tbody.append(`<tr><td colspan="5"><strong>No data available in table</strong></td></tr>`);	
					}
				});
			} 
			else 
			{
				swal("تم الغاء العمليه");
			}
		});
	});
</script>
@stop