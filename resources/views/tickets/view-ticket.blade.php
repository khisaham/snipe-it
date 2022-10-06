@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.tickets_help', array('name' => $user->present()->fullName())) }}
@parent
@stop
@section('header_right')
<a href="{{ route('create-tickets') }}" class="btn btn-primary pull-right" xmlns="http://www.w3.org/1999/html">
    {{ trans('general.new-ticket') }}</a>
@stop
{{-- Account page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">

            @if ($user->id)
            <div class="box-header with-border">
                <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.assigned_tickets', array('name' => $user->first_name)) }}</h2>
                </div>
            </div><!-- /.box-header -->
            @endif

            <div class="box-body">
                <!-- checked out assets table -->
                <div class="table-responsive">

                    <table
                            data-cookie-id-table="userLicenses"
                            data-pagination="true"
                            data-id-table="userLicenses"
                            data-search="true"
                            data-side-pagination="client"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            id="userLicenses"
                            class="table table-striped snipe-table"
                            data-export-options='{
                  "fileName": "my-licenses-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('general.ticket-no') }}</th>
                        <th class="col-md-3" data-switchable="true" data-visible="true">{{ trans('general.subject') }}</th>
                        <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('general.ticket-asset') }}</th>
                        <th class="col-md-1" data-switchable="true" data-visible="true">{{ trans('general.ticket-priority') }}</th>
                        <th class="col-md-1" data-switchable="true" data-visible="true">{{ trans('general.date-opened') }}</th>
                        <th class="col-md-1" data-switchable="true" data-visible="true">{{ trans('general.ticket-from') }}</th>
                        <th>{{ trans('general.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $count = 0
                    @endphp
                    @foreach($assigned as $ticket)
                    @php
                    $count ++;
                    @endphp
                    <tr>
                        <td>{{$count}}</td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket->id) }}">{{$ticket->ticket_no}}</a>
                        </td>
                        <td>{{$ticket->subject}}</td>
                        <td><a href="{{route('hardware.index')}}/{{$ticket->asset}}">{{($ticket->getAsset->name!=NULL || $ticket->getAsset->name !='')?$ticket->getAsset->name:$ticket->getAsset->serial}}</a></td>
                        <td><a href='{{ route('modal.show', 'priority') }}' data-toggle="modal"  data-target="#createModal" data-select='assigned_user_select'>{{$ticket->priority}}</a></td>
                        <td>{{$ticket->created_at}}</td>
                        <td><a href="{{route('users.index')}}/{{$ticket->created_by}}">{{$ticket->getCreatedBy->first_name}} {{$ticket->getCreatedBy->last_name}}</a></td>
                        <td>
                            <!--                            <div class="row">-->
                            <!--                                <div class="col-md-5">-->
                            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-xs btn-info" style="margin-right:6px;"><i class="fa fa-eye"></i></a>
                            <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></a>
                            <!--                                </div>-->
                            <!--                                <div class="col-md-5">-->
                            <!---->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div> <!-- .table-responsive-->
            </div> <!-- .box-body-->
        </div><!--.box.box-default-->
    </div> <!-- .col-md-12-->
</div> <!-- .row-->

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            @if ($user->id)
            <div class="box-header with-border">
                <div class="box-heading">
                    <h2 class="box-title"> {{ trans('general.open_tickets', array('name' => $user->first_name)) }}</h2>
                </div>
            </div><!-- /.box-header -->
            @endif

            <div class="box-body">
                <!-- checked out licenses table -->

                <div class="table-responsive">

                    <table
                            data-cookie="true"
                            data-cookie-id-table="userAssets"
                            data-pagination="true"
                            data-id-table="userAssets"
                            data-search="true"
                            data-side-pagination="client"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            id="userAssets"
                            class="table table-striped snipe-table"
                            data-export-options='{
                  "fileName": "my-assets-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('general.ticket-no') }}</th>
                        <th class="col-md-3" data-switchable="true" data-visible="true">{{ trans('general.subject') }}</th>
                        <th class="col-md-2" data-switchable="true" data-visible="true">{{ trans('general.ticket-asset') }}</th>
                        <th class="col-md-1" data-switchable="true" data-visible="true">{{ trans('general.ticket-priority') }}</th>
                        <th class="col-md-1" data-switchable="true" data-visible="true">{{ trans('general.date-opened') }}</th>
                        <th class="col-md-1" data-switchable="true" data-visible="true">{{ trans('general.ticket-from') }}</th>
                        <th>{{ trans('general.action') }}</th>
                    </tr>

                    </thead>
                    <tbody>
                    @php
                    $count = 0
                    @endphp
                    @foreach($myticket as $ticket)
                    @php
                    $count ++;
                    @endphp
                    <tr>
                        <td>{{$count}}</td>
                        <td><a href="#">{{$ticket->ticket_no}}</a></td>
                        <td><a href="#">{{$ticket->subject}}</a></td>
                        <td><a href="{{route('hardware.index')}}/{{$ticket->asset}}">{{$ticket->getAsset->name}}</a></td>
                        <td>{{$ticket->priority}}</td>
                        <td>{{$ticket->created_at}}</td>
                        <td><a href="{{route('users.index')}}/{{$ticket->created_by}}">{{$ticket->getCreatedBy->first_name}} {{$ticket->getCreatedBy->last_name}}</a></td>
                        <td>
                            <!--                            <div class="row">-->
                            <!--                                <div class="col-md-5">-->
                            <a href="#" class="btn btn-xs btn-info" style="margin-right:6px;"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-trash"></i></a>
                            <!--                                </div>-->
                            <!--                                <div class="col-md-5">-->
                            <!---->
                            <!--                                </div>-->
                            <!--                            </div>-->
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div> <!-- .table-responsive-->
            </div> <!-- .box-body-->
        </div><!--.box.box-default-->
    </div> <!-- .col-md-12-->
</div> <!-- .row-->

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop