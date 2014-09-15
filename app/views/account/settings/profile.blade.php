@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('my-profile') }}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    Account Details
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Username: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{$user->username}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Date Joined: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{$user->account->created_at}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Last Updated: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{$user->account->updated_at}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Password: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>*** <small><a href="{{URL::route('accounts.edit', $user->username)}}">(Change Password)</a></small></p>
                        </div>
                    </div>
                </div>
            </div><!-- .panel -->
        </div>
        <div class="col-lg-8">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            Employee Information
                        </div>
                        <div class="col-xs-9 text-right">
                            <a href="{{ URL::route('profile.edit', $user->username) }}"><button class="btn btn-warning btn-sm">Edit Profile</button></a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-lg-4"> Name: </div>
                                        <div class="col-lg-8"> {{$user->full_name}} </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Birthdate: </div>
                                        <div class="col-lg-8">  </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Address: </div>
                                        <div class="col-lg-8"> {{$user->full_name}} </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Email Address: </div>
                                        <div class="col-lg-8"> {{$user->email}} </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Mobile Number: </div>
                                        <div class="col-lg-8"> {{$user->mobile}} </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-4">Department:</div>
                                        <div class="col-lg-8">{{$user->department_id}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">Position:</div>
                                        <div class="col-lg-8">{{$user->position_title}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .panel -->
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
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
   {{$user->username}}
@stop