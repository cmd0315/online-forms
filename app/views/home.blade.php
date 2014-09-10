@extends('layout.outer.master')

@section('content')
   <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-offset-6">
                    <div class="intro-text">
                        <h1>Online Forms</h1>
                        <div id="home-form">
	                        <form role="form" method="post" action="#">
								<div class="form-group">
									<label for="username" class="home-label">Username</label>
									<input type="text" class="form-control" id="username" name="username"{{ (Input::old('username')) ? ' value ="' . Input::old('username') . '"' : '' }}>
									@if($errors->has('username'))
										<p class="text-danger emphasize">{{ $errors->first('username') }}</p>
									@endif
								</div>
								<div class="form-group">
									<label for="password" class="home-label">Password</label>
									<input type="password" class="form-control" id="password" name="password"{{ (Input::old('password')) ? ' value ="' . Input::old('password') . '"' : '' }}>
									@if($errors->has('password'))
										<p class="text-danger emphasize">{{ $errors->first('password') }}</p>
									@endif
								</div>
								<div class="form-group">
							      <div class="checkbox">
							        <label for="remember" class="home-label">
							          <input type="checkbox" name="remember" id="remember"> Remember me
							        </label>
							      </div>
								 </div>
								<input type="submit" name="submit" id="submit" class="btn btn-lg btn-warning" value="Sign in"/>
								{{ Form::token() }}
							</form>
						</div><!-- #home-form -->
                    </div>
                </div>
            </div>
        </div>
    </header>
@stop