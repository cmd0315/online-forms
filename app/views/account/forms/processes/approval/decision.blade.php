@extends('layout.inner.master')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Confirm Form Approval
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-4">
                                    Form ID: #{{e($onlineForm->id)}}
                                </div>
                                <div class="col-lg-4">
                                    Type: <span class="label label-warning">{{e($onlineForm->form_type)}}</span>
                                </div>
                                <div class="col-lg-4">
                                    Reference ID: #{{e($onlineForm->formable->form_num)}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-right">
                            Status: 
                            @if(e($onlineForm->departmentApproved()))
                                <span class="label label-success"> Approved</span>
                            @elseif(e($onlineForm->departmentRejected()))
                                <span class="label label-danger"> Rejected</span>
                            @else
                                <span class="label label-default"> Pending</span>
                            @endif
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-12">
                            {{Form::open(['class' => 'form-horizontal', 'route' => ['approval.update', e($onlineForm->id)], 'method' => 'PATCH'])}}
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Do you want to approve or reject the request?</h4>
                                    </div>
                                </div><!-- .row -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="radio">
                                            <label> 
                                                @if(e($onlineForm->departmentApproved()))
                                                    <input type="radio" name="decisionOptions" id="radio-approve" value="0" checked> Accept Request
                                                @else
                                                    <input type="radio" name="decisionOptions" id="radio-approve" value="0"> Accept Request
                                                @endif
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                @if(e($onlineForm->departmentRejected()))
                                                    <input type="radio" name="decisionOptions" id="radio-reject" value="1" checked> Reject Request
                                                @else
                                                    <input type="radio" name="decisionOptions" id="radio-reject" value="1"> Reject Request
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div><!-- .row -->
                                <div class="row" style="display:none;" id="reject-reasons">
                                    <div class="col-lg-12">
                                        <h5>Reasons:</h5>
                                        @if(count($whyRejectedArr) > 0 )
                                            @foreach($formRejectReasons as $formRejectReason)
                                                @if(in_array($formRejectReason->id, $whyRejectedArr))
                                                    <div class="checkbox">
                                                        <label> <input type="checkbox" class="reject-checkbox" name="formRejectReasons[]" value="{{$formRejectReason->id}}" checked> {{$formRejectReason->rejectReason->reason}}</label>
                                                    </div><!-- checkbox -->
                                                @else
                                                    <div class="checkbox">
                                                        <label> <input type="checkbox" class="reject-checkbox" name="formRejectReasons[]" value="{{$formRejectReason->id}}"> {{$formRejectReason->rejectReason->reason}}</label>
                                                    </div><!-- checkbox -->
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach($formRejectReasons as $formRejectReason)
                                                <div class="checkbox">
                                                    <label> <input type="checkbox" class="reject-checkbox" name="formRejectReasons[]" value="{{$formRejectReason->id}}"> {{$formRejectReason->rejectReason->reason}}</label>
                                                </div><!-- checkbox -->
                                            @endforeach
                                        @endif

                                    </div>
                                </div><!-- .row -->
                                <div class="row">
                                    <div class="col-lg-12 text-right">
                                        <a class="btn btn-default" href="{{ URL::route('approval.show', e($onlineForm->id)) }}">Review Request</a>
                                        <button type="submit" class="btn btn-warning" id="submit-decision">Submit</button>
                                    </div>
                                </div><!-- .row -->
                                <input type="hidden" id="approver" name="approver" value="{{$currentUser->username}}">
                            {{ Form::close() }}
                        </div>
                    </div><!-- .row -->
                </div>
            </div>
        </div>
        
    </div><!-- .row -->
@stop

@section('sub-heading')
    Payment Request - <strong>#{{e($onlineForm->formable->form_num)}}</strong>
@stop
