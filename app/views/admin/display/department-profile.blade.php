@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('department-profile', e($department->department_id)) }}
@stop

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
                            @if(($currentUser->system_admin))
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ URL::route('departments.edit', e($department->department_id)) }}" class="btn btn-primary">Edit</a>  
                                   <button class="btn btn-danger btn-sm" name="remove-department-acct-btn" id="remove-department-acct-btn" data-toggle="modal" data-target="#myModal">Remove</button>
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
                            <p>{{ e($department->last_profile_update) }}</p>
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
                            @if(($currentUser->system_admin))
                                <div class="btn-group btn-group-sm">
                                    <a href="#" class="btn btn-primary">Add Member</a>  
                                    <a href="#" class="btn btn-warning">Export List</a>   
                                </div><!-- .btn-group -->
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
                                        @if($member->head)
                                            <li><a href="{{ URL::route('employees.show', e($member->username)) }}">{{ e($member->full_name) }} </a> ({{ e($member->position_title) }})</li>
                                        @else
                                            <li><a href="{{ URL::route('employees.show', e($member->username)) }}">{{ e($member->full_name) }} </a></li>
                                        @endif  
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

@section('modal-content')
<div class="modal-content">
    {{ Form::open(['id' => 'modal-form', 'route' => ['employees.destroy'], 'method' => 'DELETE']) }}
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Remove Department</h4>
        </div>
        <div class="modal-body">
            Are you sure you want to remove <span id="subject-name"></span> department?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default cancel-btn" id="cancel-btn2" data-dismiss="modal">Cancel</button>
            {{ Form::submit('OK', array('class' => 'btn btn-warning')) }}
        </div>
        {{ Form::token() }}
    {{ Form::close() }}
</div><!-- .modal-content -->
@stop