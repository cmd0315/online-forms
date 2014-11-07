@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('list-clients') }}
@stop

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="row table-toolbar">
			<div class="col-lg-9">
				<div class="btn-toolbar" role="toolbar">
					<div class="btn-group btn-group-sm">
						<a href="{{ URL::route('clients.create') }}" class="btn btn-primary">Add Client</a>
						<a href="{{ URL::route('clients.export') }}" class="btn btn-warning">Export List</a>
  						<button type="button" class="btn btn-danger">Remove Client</button>
					</div><!-- .btn-group -->
				</div><!-- .btn-toolbar -->
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
				<h4>Total Clients: <small>{{ $total_clients }}</small></h4>
			</div>
			<div class="col-lg-10">
				@if(isset($search))
					<h4>Search: <mark>{{ $search }}</mark></h4>
				@endif
			</div>
		</div>
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
							<?php $counter=0; ?>
							@foreach($clients as $client)
								<tr>
									<td>{{ ++$counter }}</td>
									<td><a href="{{ URL::route('clients.show', ['client_id' => $clientID = e($client->client_id)]) }}">{{ $clientID }}</a></td>
									<td> {{ e($client->client_name) }} </td>
									<td> {{ e($client->address) }} </td>
									<td> {{ e($client->contact_person) }} </td>
									<td> {{ e($client->email) }} </td>
									<td> {{ e($client->mobile) }} </td>
									<td> {{ e($client->telephone) }} </td>
									<td> {{ e($client->updated_at) }} </td>
									<td> {{ e($client->created_at) }} </td>
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