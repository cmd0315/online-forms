@include('layout.partials._form_header')
	<body id="online-form">
		<div id="form-wrapper">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-2 col-xs-2" id="form-navigation">
						@include('layout.inner.forms._navigation')
					</div>
					<div class="col-lg-10 col-xs-10" id="form-content">
						<div class="row-fluid">
							<div class="col-lg-12 col-xs-12 form-header">
								<h2 class="form-title">{{ isset($pageTitle) ? $pageTitle : '' }}</h2>
								<h4 class="form-number">No. {{ $formNum }}</h4>
							</div>
						</div><!-- .row-fluid -->
						@include('flash::message')

						@yield('content')
					</div>
				</div>
			</div><!-- .container-fluid -->
		</div><!-- #form-wrap -->
@include('layout.partials._footer')