<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/core.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/components.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('temp/assets/css/colors.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="{{ asset('temp/assets/js/plugins/loaders/pace.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('temp/assets/js/core/libraries/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('temp/assets/js/core/libraries/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('temp/assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="{{ asset('temp/assets/js/plugins/forms/styling/uniform.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('temp/assets/js/core/app.js') }}"></script>
	<script type="text/javascript" src="{{ asset('temp/assets/js/pages/login.js') }}"></script>

	<script type="text/javascript" src="{{ asset('temp/assets/js/plugins/ui/ripple.min.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body class="login-container">

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content pb-20">

					<!-- Advanced login -->
					{!! Form::open(['action' => 'Auth\Admin\AdminLoginController@adminLogin', 'method' => 'POST']) !!}
						<div class="panel panel-body login-form">
							<div class="text-center">
								<h5 class="content-group-lg">Login to your account <small class="display-block">Enter your credentials</small></h5>
							</div>

							<div class="form-group has-feedback {{ $errors->first('email' , 'has-error') }} has-feedback-left">
								<input type="text" name="email" class="form-control" placeholder="البريد الالكتروني">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
								@if ($errors->has('email'))
                    				<span class="help-block alpaca-message alpaca-message-invalidPattern"><strong>{{ $errors->first('email') }}</strong></span>
                				@endif
							</div>

							<div class="form-group has-feedback {{ $errors->first('password' , 'has-error') }} has-feedback-left">
								<input type="password" name="password" class="form-control" placeholder="كلمة المرور">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								@if ($errors->has('password'))
                    				<span class="help-block alpaca-message alpaca-message-invalidPattern"><strong>{{ $errors->first('password') }}</strong></span>
                				@endif
							</div>

							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" class="styled" checked="checked"> تذكرني
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="{{ route('password.request') }}">هل نسيت كلمة المرور ؟</a>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" name="submit" class="btn bg-pink-400 btn-block">
									تسجيل الدخول <i class="icon-arrow-left13 position-right"></i>
								</button>
							</div>

							<span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
						</div>
					{!! Form::close() !!}
					<!-- /advanced login -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
