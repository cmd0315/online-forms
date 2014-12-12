@extends('layout.inner.master')

@section('breadcrumbs')
  {{ Breadcrumbs::render('show-payment-request', e($paymentRequest->form_num)) }}
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
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Form Number: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p class="text-danger"><strong>{{ e($paymentRequest->form_num) }}</strong></p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Created At: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p>{{ e($paymentRequest->onlineForm->created_at) }}</p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Last Updated By: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p>{{ e($paymentRequest->onlineForm->updated_by_with_link) }}</p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Last Updated At: </p>
                                </div>
                                <div class="col-lg-7">
                                    <p>{{ e($paymentRequest->onlineForm->updated_at) }}</p>
                                </div>
                            </div><!-- .row -->
                            <div class="row">
                                <div class="col-lg-5">
                                    <p> Request Status: </p>
                                </div>
                                <div class="col-lg-7">
                                </div>
                            </div><!-- .row -->
                        </div>
                    </div><!-- .panel -->
                </div>
            </div><!-- .row -->
            <div class="row">
                <div class="col-lg-12 text-center">
                    <a class="btn btn-warning col-lg-12" href="#">Print Form</a>
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
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-4">
                            Payee:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->payee_fullname) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Particulars:
                        </div>
                        <div class="col-lg-8">
                            <textarea class="form-control" name="particulars" rows="5" readonly>{{ e($paymentRequest->particulars) }}</textarea>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Date Requested:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->date_requested) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Total Amount:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->total_amount_formatted) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Department:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->onlineForm->department->profile_link) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Client:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->client->profile_link) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Check Num:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->check_num) }}
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Date Needed:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->date_needed) }}
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
                            <span>{{ e($paymentRequest->onlineForm->updated_by_with_link) }}</span>
                            <span class="badge">on 2014-11-03</span>
                            <ul> 
                                <li>Printed the form</li>
                                <li>Updated the form</li>
                            </ul>
                        </li>
                        <li>
                            <span>{{ e($paymentRequest->onlineForm->updated_by_with_link) }}</span>
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
                            <p>{{ e($paymentRequest->onlineForm->created_by_with_link) }}</p>
                        </div>
                    </div><!-- .row -->
                    <div class="row">
                        <div class="col-lg-4">
                            Approved By:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->onlineForm->approved_by_with_link) }}
                        </div>
                    </div><!-- .row -->    
                    <div class="row">
                        <div class="col-lg-4">
                            Received By:
                        </div>
                        <div class="col-lg-8">
                            {{ e($paymentRequest->onlineForm->received_by_with_link) }}
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