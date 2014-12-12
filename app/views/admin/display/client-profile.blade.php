@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('client-profile', e($client->client_id)) }}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-danger">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-6">
                            Client Information
                        </div>
                        <div class="col-xs-6 text-right">
                            @if(($currentUser->system_admin))
                            <div class="btn-group btn-group-sm">
                                @if( !($client->isDeleted()) )
                                    <a href="{{ URL::route('clients.edit', e($client->client_id)) }}" class="btn btn-primary">Edit</a>  
                                    <button class="btn btn-danger btn-sm" name="remove-acct-btn" id="remove-acct-btn" data-toggle="modal" data-target="#myModal">Remove Client</button>
                                @else
                                    <a href="{{ URL::route('clients.restore', e($client->client_id)) }}" class="btn btn-warning">Restore</a>
                                @endif
                            </div><!-- .btn-group -->
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <p> ID: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($client->client_id) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Name: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($client->client_name) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Contact Person: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($client->contact_person) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Contact Numbers: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>Email: <em> <a href="mailto:{{ $email = e($client->email) }}">{{ $email }}</a> </em></p>
                            <p>Mobile: <em> <a href="tel:{{ $mobile = e($client->mobile) }}">{{ $mobile }}</a> </em></p>
                            <p>Telephone: <em> <a href="tel:{{ $telephone = e($client->telephone) }}">{{ $telephone }}</a> </em></p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Date Joined: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($client->created_at) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Last Updated: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($client->last_profile_update) }}</p>
                        </div>
                    </div><!-- .row -->
                </div>
            </div><!-- .panel -->
        </div>
        <div class="col-lg-7">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Transaction History
                </div><!-- .panel-heading -->
                <div class="panel-body">
                    <ul>
                        <li>hello</li>
                        <li>hello</li>
                        <li>hello</li>
                        <li>hello</li>
                        <li>hello</li>
                    </ul>
                </div><!-- .panel-body -->
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-right">Print Transaction Records</span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div><!-- .panel -->
        </div>
    </div>
    <!-- /.row -->
@stop

@section('sub-heading')
   {{$client->client_name}}
@stop

@section('modal-content')
<div class="modal-content">
  {{ Form::open(['id' => 'modal-form', 'route' => ['clients.destroy', e($client->client_id)], 'method' => 'DELETE']) }}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <h4 class="modal-title" id="myModalLabel">Deactivate Client Account</h4>
    </div>
    <div class="modal-body">
      Are you sure you want to deactivate client's account?
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      {{ Form::submit('OK', array('class' => 'btn btn-warning')) }}
    </div>
  {{ Form::close() }}
</div><!-- .modal-content -->
@stop