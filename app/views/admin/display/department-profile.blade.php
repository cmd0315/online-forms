@extends('layout.inner.master')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="panel panel-danger">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-6">
                            Department Information
                        </div>
                        <div class="col-xs-6 text-right">
                            @if(($currentUser->employee->system_admin))
                            <div class="btn-group btn-group-sm">
                                <a href="{{ URL::route('departments.edit', e($department->department_id)) }}" class="btn btn-primary">Edit</a>  
                                <a href="{{ URL::route('departments.destroy', e($department->department_id)) }}" class="btn btn-danger">Remove</a>   
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
                            <p>{{ e($department->department_id) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Name: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($department->department_name) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Date Joined: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($department->created_at) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Last Updated: <p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($department->last_department_profile_update) }}</p>
                        </div>
                    </div><!-- .row -->
                </div>
            </div><!-- .panel -->
        </div>
        <div class="col-lg-7">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            List of Members
                        </div>
                        <div class="col-xs-9 text-right">
                            @if(($currentUser->employee->system_admin))
                                <a href="#"><button class="btn btn-warning btn-sm">Export List</button></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if($members->count())
                                <ul>
                                    @foreach($members as $member)
                                        <li><a href="{{ URL::route('employees.show', e($member->username)) }}">{{ e($member->full_name) }} </a></li>   
                                    @endforeach
                                </ul>
                            @endif
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
   {{$department->department_name}}
@stop