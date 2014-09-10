@include('layout.partials._header')
	<body id="online-form">
		<div id="form-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-2" id="form-navigation">
						@include('layout.inner.forms._navigation')
					</div>
					<div class="col-lg-10" id="form-content">
						@yield('content')
					</div>
				</div>
			</div><!-- .container-fluid -->
		</div><!-- #form-wrap -->
