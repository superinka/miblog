<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title')</title>

	<!-- HEAD -->
    @include("layouts.elements.head")

	<!-- Theme JS files -->
	{{--  <script type="text/javascript" src="assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/pickers/daterangepicker.js"></script>  --}}

	<script type="text/javascript" src="{{ asset('theme/assets/js/core/app.js') }}"></script>
	{{--  <script type="text/javascript" src="assets/js/pages/dashboard.js"></script>  --}}
	<!-- /theme JS files -->

</head>

<body>
	<!-- MAIN-NAV -->
    @include("layouts.elements.main-nav")
	

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- MAIN-SIDEBAR -->
            @include("layouts.elements.main-sidebar")

			<!-- Main content -->
			<div class="content-wrapper">

                <!-- PAGE-HEADER -->
                @include("layouts.elements.page-header")


				<!-- Content area -->
				<div class="content">
                    
                    @yield('content')

					<!-- Footer -->
					<div class="footer text-muted">
						&copy; 2018. <a href="#">MIBLOG</a> by <a href="#" target="_blank">Inka</a>
					</div>
					<!-- /footer -->

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
