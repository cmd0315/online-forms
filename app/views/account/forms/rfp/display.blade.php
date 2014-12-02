@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('show-payment-request', e($form->form_num)) }}
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                             <div class="row">
                                <div class="col-lg-7">
                                    Metadata
                                </div>
                                <div class="col-lg-5 text-right">
                                    @if(e($currentUser->username) == e($form->onlineForm->created_by))
                                        @if(!($form->onlineForm->closed()))
                                            <button type="button" class="btn btn-danger btn-sm" id="close-btn" name="close-btn" data-toggle="modal" data-target="#myModal">Close Request</button>
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm" id="open-btn" name="open-btn" data-toggle="modal" data-target="#myModal">Open Request</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Form Number: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p class="text-danger"><strong>{{ e($form->form_num) }}</strong></p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Created At: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p>{{ e($form->onlineForm->created_at) }}</p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Last Updated By: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p>{{ e($form->onlineForm->updated_by_formatted) }}</p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Last Updated At: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p>{{ e($form->onlineForm->updated_at) }}</p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Request Status: </p>
                                </div>
                                <div class="col-lg-7">
                                    {{ e($form->onlineForm->request_status_formatted) }}
                                    <ul class="why-rejected-list">
                                        @foreach($form->onlineForm->rejectHistories as $rejectHistory)
                                            <li>{{e($rejectHistory->formRejectReasons->rejectReason->reason)}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div><!-- .row -->
                        </div>
                    </div><!-- .panel -->
                </div>
            </div><!-- .row -->
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a class="btn btn-warning col-lg-12" href="{{ URL::route('rfps.pdf', e($form->form_num)) }}">Print Form</a>
                </div>
            </div><!-- .row -->
        </div>
        <div class="col-lg-8">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-9">
                            Details
                        </div>
                        <div class="col-lg-3 text-right">
                            @if($currentUser->employee->isForEditing(e($form->onlineForm->id)))
                                <a class="btn btn-warning btn-sm" href="{{ URL::route('rfps.edit', e($form->form_num)) }}">Edit Request</a>
                            @endif
                            @if($currentUser->employee->isForApproving(e($form->onlineForm->id)))
                                <a class="btn btn-danger btn-sm" href="{{ URL::route('approval.edit', e($form->onlineForm->id)) }}">Approve Request</a>
                            @endif
                            @if($currentUser->employee->isForReceiving(e($form->onlineForm->id)))
                                <a class="btn btn-danger btn-sm" href="{{ URL::route('receiving.edit', e($form->onlineForm->id) )}}">Receive Request</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            Payee:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->payee_fullname) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Particulars:
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="particulars" rows="5" readonly>{{ e($form->particulars) }}</textarea>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Date Requested:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->date_requested) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Total Amount:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->total_amount_formatted) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Department:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->onlineForm->department_formatted) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Client:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->client_formatted) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Check Num:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->check_num) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Date Needed:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->date_needed) }}
                        </div>
                    </div><!-- .row -->
                </div>
            </div><!-- .panel -->
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-9">
                            Activities
                        </div>
                        <div class="col-lg-3 text-right">
                            <button class="btn btn-default btn-sm">Print Transaction Records</button>
                        </div>
                    </div>
                </div><!-- .panel-heading -->
                <div class="panel-body">
                    <ul class="list-group activitylist">
                        <li>
                            <span>{{ e($form->onlineForm->updated_by_formatted) }}</span>
                            <span class="badge">on 2014-11-03</span>
                            <ul> 
                                <li>Printed the form</li>
                                <li>Updated the form</li>
                            </ul>
                        </li>
                        <li>
                            <span>{{ e($form->onlineForm->updated_by_formatted) }}</span>
                            <span class="badge">on 2014-11-03</span>
                            <ul>
                                <li>Created the form</li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- .panel-body -->
            </div><!-- .panel -->
        </div>
        <div class="col-lg-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                     <div class="row">
                        <div class="col-xs-5">
                            Collaborators
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <p> Created By: </p>
                        </div>
                        <div class="col-lg-8">
                            <p>{{ e($form->onlineForm->created_by_formatted) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Approved By:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->onlineForm->approved_by_formatted) }}
                        </div>
                    </div><!-- .row -->    
                    <div class="row">
                        <div class="col-lg-4">
                            Received By:
                        </div>
                        <div class="col-lg-8">
                            {{ e($form->onlineForm->received_by_formatted) }}
                        </div>
                    </div><!-- .row -->    
                </div>
            </div><!-- .panel -->
        </div>
    </div>
    <!-- /.row -->
@stop

@section('sub-heading')
   {{$subHeading}}
@stop

@section('modal-content')
     @if(e($currentUser->username) == e($form->onlineForm->created_by))
        <div class="modal-content">
            @if(!($form->onlineForm->closed()))
                {{ Form::open(['route' => ['rfps.destroy', e($form->onlineform->id)], 'method' => 'DELETE']) }}
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Close Request</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to close this request?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cancel-btn" id="cancel-btn2" data-dismiss="modal">Cancel</button>
                        {{ Form::submit('Close Request', array('class' => 'btn btn-danger btn-sm')) }}
                    </div>
                {{ Form::close() }}
            @else
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Open Request</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to open this request?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default cancel-btn" id="cancel-btn2" data-dismiss="modal">Cancel</button>
                    </div>
            @endif
        </div><!-- .modal-content -->
    @endif
@stop