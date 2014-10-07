
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" 
   data-keyboard="false">
  <div class="modal-dialog">
  	@yield('modal-content')
  </div>
</div><!-- .modal -->

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
	{{ HTML::script('js/scripts.js') }}
	@yield('extra-scripts')
</body>
</html>