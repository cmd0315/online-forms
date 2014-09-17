<div class="panel panel-warning">
    <div class="panel-heading">
        <h3 class="panel-title">Settings</h3>
    </div>
    <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
			<li><a href="{{ URL::route('accounts.edit', Auth::user()->employee->username)}}">Change Password</a></li>
			<li><a href="{{ URL::route('profile.edit', Auth::user()->employee->username)}}">Update Profile Information</a></li>
			<li><a href="{{ URL::route('home.signout') }}">Sign out</a></li>
		</ul>
    </div>
</div>