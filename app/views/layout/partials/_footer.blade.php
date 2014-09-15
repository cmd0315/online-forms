
<!-- Splash Message -->
@if(Session::has('global'))
	<div class="alert alert-info flash-msg">
		<p class="emphasize"> {{ Session::get('global') }} </p>
	</div>
@elseif(Session::has('global-error'))
	<div class="alert alert-danger flash-msg">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<p class="emphasize"> {{ Session::get('global-error') }} </p>
	</div>
@elseif(Session::has('global-successful')) 
	<div class="alert alert-success flash-msg">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<p class="emphasize"> {{ Session::get('global-successful') }} </p>
	</div>
@endif

<!-- Footer -->
<footer>
    <div class="footer-above">
        <div class="container">
            <div class="row">
            	<div class="footer-col col-md-6">
            		@yield('breadcrumb')
                </div>
                <div class="footer-col col-md-6" id="copyright">
                    Copyright &copy; BCD Pinpoint Direct Marketing 2014
                </div>
            </div>
        </div>
    </div>
</footer>

	<!-- js -->
	<!-- {{ HTML::script('https://code.jquery.com/jquery-1.10.2.min.js') }} -->
	{{ HTML::script('js/jquery.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	@yield('extra-scripts')
	<script>
  		jQuery(document).ready(function($){
  			$(".flash-msg").fadeIn('slow').delay(5000).fadeOut('slow');
			@yield('scripts')
  		});
  	</script>
</body>
</html>