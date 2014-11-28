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
                                    <a href="{{ URL::route('clients.destroy', e($client->client_id)) }}" class="btn btn-danger">Remove</a>
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