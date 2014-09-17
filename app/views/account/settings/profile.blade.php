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
                            <p>{{ e($user->username) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Date Joined: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($user->account->created_at) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Last Updated: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($user->account->updated_at) }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Password: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>*** <small>
                                @if((Auth::user()->employee->system_admin) && (e($user->username) !== Auth::user()->username))
                                    <a href="#">(Reset Password)</a>
                                @else
                                    <a href="{{URL::route('accounts.edit', e($user->username)) }}">(Change Password)</a>
                                @endif
                            </small></p>
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
                            @if(Auth::user()->employee->system_admin)
                                <a href="{{ URL::route('employees.edit', e($user->username)) }}"><button class="btn btn-warning btn-sm">Edit Profile</button></a>
                            @else
                                <a href="{{ URL::route('profile.edit', e($user->username)) }}"><button class="btn btn-warning btn-sm">Edit Profile</button></a>    
                            @endif
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
                                        <div class="col-lg-8"> {{ e($user->full_name) }} </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Birthdate: </div>
                                        <div class="col-lg-8">  {{ date('Y-m-d', strtotime(e($user->birthdate))) }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Address: </div>
                                        <div class="col-lg-8"> {{ e($user->address) }} </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Email Address: </div>
                                        <div class="col-lg-8"> {{ e($user->email) }} </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4"> Mobile Number: </div>
                                        <div class="col-lg-8"> {{ e($user->mobile) }} </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-lg-4">Department:</div>
                                        <div class="col-lg-8">{{ e($user->department->department_name) }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">Position:</div>
                                        <div class="col-lg-8">{{ e($user->position_title) }}</div>
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