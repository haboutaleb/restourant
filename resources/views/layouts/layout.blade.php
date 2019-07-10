<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="http-root" content="{{ url(Request::root()) }}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script> window.laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!} </script>

	<title> بيلا روزا || @yield('title') </title>

    <!-- live-search stylesheets -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.css">
	<link href="{{ asset('temp/assets/css/live-search.css') }}" rel="stylesheet" type="text/css">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/core.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/components.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/colors.css') }}" rel="stylesheet" type="text/css">


	<link href="{{ asset('temp/assets/css/style-rtl.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/responsive-style.css') }}" rel="stylesheet" type="text/css">

	<!-- /global stylesheets -->

    @yield('style')

	<!-- Core JS files -->

	<script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/pace.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" charset="UTF-8"></script>
	<!-- live-search JS files -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.3/semantic.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/live-search.js') }}"></script>


    {{-- <script type="text/javascript" src="{{ url('/temp/assets') }}/js/plugins/visualization/echarts/echarts.js"></script> --}}

	<script type="text/javascript" src="{{ url('/temp/assets') }}/js/core/app.js"></script>
	{{-- <script type="text/javascript" src="{{ url('/temp/assets') }}/js/charts/echarts/pies_donuts.js"></script> --}}

	<script type="text/javascript" src="{{ url('/temp/assets') }}/js/plugins/ui/ripple.min.js"></script>
	<script type="text/javascript" src="{{ url('/temp/assets') }}/js/pages/datatables_basic.js"></script>
	<script type="text/javascript" src="{{ url('/temp/assets') }}/js/pages/form_checkboxes_radios.js"></script>


	<script>
		// $(document).ready(function(){
		// 	$('.ui.search').search({
		// 		apiSettings: {
		// 			url: ''
		// 		},

		// 		fields: {
		// 			results: 'items',
		// 			title: 'full_name',
		// 			url: "dashboardurl",
		// 			image: 'imageurl'
		// 		},
		// 		error: {
		// 			noResults: 'لا توجد نتيجة'
		// 		},
		// 		minCharacters: 1
		// 	});
		// });
	</script>
</head>
<body>
    @include('Back.includes.navbar')

	<!-- Page container -->
	<div class="page-container">

        <!-- Page content -->
		<div class="page-content">            
            @include('Back.includes.sidebar')

			<!-- Main content -->
			<div class="content-wrapper">
				{{-- @include('Back.includes.flash') --}}

				@if(isset($page_header)) @include($page_header)
				
				@else @include('Back.includes.header')
				
				@endif

				@if (session('message') && session('class'))
				<div style="padding: 5px 25px;direction: rtl;">
					<div class="{{  session('class') }}">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{ session('message') }}
                	</div>
            	</div>
				@endif

				@if(session('swal') && session('icon'))
				<script>
					swal({
						title: "{{ trans('alert') }}",
						text: "{{ session('swal') }}",
						icon: "{{ session('icon') }}",
						timer:2000
					});
				</script>
				@endif

				@forelse($errors->all() as $message)
				<div style="padding: 0px 20px">
					<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{ $message }}
					</div>
				</div>
				@empty
				@endforelse

				<!-- Content area -->
				<div class="content">
					@yield('content')
					@include('Back.includes.footer')
				</div>
				<!-- /content area -->
			</div>
			<!-- /main content -->
		</div>
		<!-- /page content -->
	</div>
	<!-- /page container -->
	<script>
	    function sweet_delete($url,$message,$row_id)
	    {
	        $( "#row_"+$row_id ).css('background-color','#000000').css('color','white');
	        swal({
	        title: $message,
	        icon: "warning",
	        buttons: true,
	        dangerMode: true,
	        })
	        .then((willDelete) => {
	        if (willDelete) {
	            $.ajax({
	                url:$url
	            });
	            swal({
	                title: "{{ trans('alert') }}",
	                text: "{{ trans('dash.deleted_successfully') }}",
	                icon: "success",
	                timer:1000
	            });
	            $( "#row_"+$row_id ).hide(1000);
	        }else{
	            $( "#row_"+$row_id ).removeAttr('style');
	        }
	        });
	    }
	</script>
	
	@yield('script')

	<script src="{{ asset('assets/js/bootbox.min.js') }}"></script>
	<script src="{{ asset('assets/js/crud.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>
</body>
</html>
