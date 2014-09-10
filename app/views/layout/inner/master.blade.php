@include('layout.partials._header')
	body
		<div id="wrapper">
			@include('layout.inner._navigation')
			<div id="page-wrapper">
				<div class="container-fluid">
				    <!-- Page Heading -->
				    <div class="row">
				        <div class="col-lg-12">
				            <h1 class="page-header">
				                Dashboard <small>Statistics Overview</small>
				            </h1>
				            <ol class="breadcrumb">
				                <li class="active">
				                    Dashboard
				                </li>
				            </ol>
				        </div>
				    </div>
				    <!-- /.row -->
					@yield('content')
				</div> <!-- /.container-fluid -->
			</div> <!-- #page-wrapper -->
		</div><!-- #wrapper -->
@include('layout.partials._footer')
