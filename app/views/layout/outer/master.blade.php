@include('layout.partials._header')
	<body>
		@include('layout.outer._navigation')
		   <!-- Header -->
		    <header>
		        <div class="container">
		            <div class="row">
						<div class="col-lg-6 col-lg-offset-6">
						    <div class="intro-text">
						        <h1>@yield('title')</h1>
								@yield('content')
							</div><!-- .intro-text -->
						</div>
					</div><!-- .row -->
				</div><!-- .container -->
			</header>
@include('layout.partials._footer')
