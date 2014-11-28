@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('list-clients') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row table-toolbar">
			<div class="col-lg-3">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group btn-group-sm">
						<a href="{{ URL::route('clients.create') }}" class="btn btn-primary">Add Client</a>
						<button type="button" id="{{ URL::route('clients.export') }}" class="btn btn-warning export">Export List</button>
  						<button type="button" class="btn btn-danger" id="remove-btn" name="remove-btn">Remove Client</button>
  						<a class="btn btn-default cancel-btn" id="cancel-btn1" name="cancel-btn1">Cancel Remove</a>
					</div><!-- .btn-group -->
				</div><!-- .btn-toolbar -->
			</div>
			<div class="col-lg-6">
				<div class="progress-div" style="display:none;">
					<i class="fa fa-lg fa-cog fa-spin"></i> Exporting the data ...
				</div>
			</div>
			<div class="col-lg-3">
				{{ Form::open(['method' => 'GET', 'route' => 'clients.index']) }}
			      <div class="input-group input-group-sm">
			         {{ Form::input('search', 'q', null, ['class' => 'form-control', 'placeholder' => 'Search']) }}
			          <span class="input-group-btn">
			            <button class="btn btn-default btn-warning" type="submit">Search</button>
			          </span>
			      </div><!-- /input-group -->
			    {{ Form::close() }}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2">
				<h4>Active: <small>{{ $active_clients }}</small></h4>
			</div>
			<div class="col-lg-2">
				<h4>Total: <small>{{ $total_clients }}</small></h4>
			</div>
			<div class="col-lg-8">
				@if(isset($search))
					<h5>Search:  <mark>{{ $search }}</mark> <a href="{{ URL::route('clients.index') }}"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a></h5>
				@endif
			</div>
		</div><!-- .row -->
		<div class="row">
			<div class="col-lg-12">
			    @if($clients->count())
			    	<div class="table-responsive">
						<table class="table table-condensed table-hover table-big" id="employee-table">
							<thead>
								<tr>
									<td>#</td>
									<td>{{ sort_clients_by('client_id', 'ID') }}</td>
									<td>{{ sort_clients_by('client_name', 'Name') }}</td>
									<td>Status</td>
									<td>{{ sort_clients_by('address', 'Address') }}</td>
									<td>{{ sort_clients_by('cp_last_name', 'Contact Person') }}</td>
									<td>{{ sort_clients_by('email', 'Email Address') }}</td>
									<td>{{ sort_clients_by('mobile', 'Mobile') }}</td>
									<td>{{ sort_clients_by('telephone', 'Landline') }}</td>
									<td>{{ sort_clients_by('updated_at', 'Last Updated At') }}</td>
									<td>{{ sort_clients_by('created_at', 'Date Joined') }}</td>
									<td></td>
								</tr>
							</thead>
							<tbody>
							@foreach($clients as $client)
								@if($client->isDeleted())
									<tr class="danger">
								@else
									<tr>
								@endif
										<td>{{ ++$currentRow }}</td>
										<td><a href="{{ URL::route('clients.show', ['client_id' => $clientID = e($client->client_id)]) }}">{{ $clientID }}</a></td>
										<td> {{ e($client->client_name) }} </td>
										<td> {{ e($client->clientStatus) }} </td>
										<td> {{ e($client->address) }} </td>
										<td> {{ e($client->contact_person) }} </td>
										<td> {{ e($client->email) }} </td>
										<td> {{ e($client->mobile) }} </td>
										<td> {{ e($client->telephone) }} </td>
										<td> {{ e($client->updated_at) }} </td>
										<td> {{ e($client->created_at) }} </td>
										@if( !($client->isDeleted()) )
											<td><button class="btn btn-delete" id="{{ e($client->client_name) }}" value="{{ URL::route('clients.destroy', e($client->client_id)) }}" style="display:none;">X</button></td>
										@endif
									</tr>
							@endforeach
							</tbody>
						</table>
					</div><!-- .table-responsive -->
					{{ $clients->appends(Request::except('page'))->links(); }}
			    @else
			      <h5>No Results found</h5>
			    @endif
			</div>
		</div>
	</div>
</div><!-- .row -->
@stop

@section('modal-content')
<div class="modal-content">
	{{ Form::open(['id' => 'modal-form', 'route' => ['clients.destroy'], 'method' => 'DELETE']) }}
		<div class="modal-header">
			<h4 class="modal-title" id="myModalLabel">Remove Client</h4>
		</div>
		<div class="modal-body">
			Are you sure you want to remove <span id="subject-name"></span> client?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default cancel-btn" id="cancel-btn2" data-dismiss="modal">Cancel</button>
			{{ Form::submit('OK', array('class' => 'btn btn-warning')) }}
		</div>
	{{ Form::close() }}
</div><!-- .modal-content -->
@stop