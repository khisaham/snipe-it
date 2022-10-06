@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.ticket') }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right" xmlns="http://www.w3.org/1999/html">
    {{ trans('general.back') }}</a>
@stop
{{-- Page content --}}
@section('content')
<style>
    #map {
        height: 600px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
    }
</style>
<div class="row">

    <div class="col-md-9">
        <div class="box box-default">
            <div class="box-body">
                <div class="table-responsive">
                   <table class="table table-responsive">
                       <tr>
                           <td>Ticket Number</td>
                           <td>{{$ticket->ticket_no}}</td>
                           <td></td>
                           <td>Priority: {{$ticket->priority}}</td>
                       </tr>
                       <tr>
                           <td>Subject</td>
                           <td>{{$ticket->subject}}</td>
                           <td></td>
                           <td></td>
                       </tr>
                       <tr>
                           <td>Asset Type</td>
                           <td>{{$ticket->getAsset->name}}</td>
                           <td></td>
                           <td></td>
                       </tr>
                       <tr>
                           <td>Created By</td>
                           <td>{{$ticket->getCreatedBy->first_name}} {{$ticket->getCreatedBy->last_name}}</td>
                           <td></td>
                           @if(!empty($ticket->assigned_to) && $ticket->assigned_to != null)
                           <td>Assigned To: {{$ticket->getAssignedTo->first_name}} {{$ticket->getAssignedTo->last_name}}</td>
                           @endif
                       </tr>
                       <tr>
                           <td>Ticket Type</td>
                           <td>{{$ticket->type}}</td>
                           <td></td>
                           <td></td>
                       </tr>
                       <tr>
                           <td>Created On</td>
                           <td>{{$ticket->created_at}}</td>
                           <td></td>
                           <td></td>
                       </tr>
                       <tr>
                           <td>Description</td>
                           <td colspan="3">{{$ticket->description}}</td>
                       </tr>
                       <tr>
                           <td>Status</td>
                           <td>
                               @php echo $ticket->statusBadge @endphp
                           </td>
                       </tr>
                   </table>
                </div>

            </div>
        </div>
        <div class="box box-default">
            <div class="box-body">
                <form id="update-ticket-form" class="has-validation-callback" method="post" action="{{route('update-ticket')}}" autocomplete="off" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="ticket_id" value="{{$ticket->id}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="0">Re-Open</option>
                            <option value="1">Pending</option>
                            <option value="2">Re-assign</option>
                            <option value="3">Solved and Closed</option>
                            <option value="4">Closed no Solution</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Update Solution</label>
                        <textarea class="form-control" name="solution"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="pull-right btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- side address column -->
    <div class="col-md-3">
        <h2>Ticket Activities</h2>
        <p>All activities done on this ticket</p>
        <!-- Section: Timeline -->
        <section class="py-5" style="height: 490px; overflow-y: scroll;">
            <ul class="timeline">
                @foreach($ticket_activities as $activity)
                <hr/>
                <li class="timeline-item mb-5">
                    <h5 class="fw-bold">{{$activity->subject}}</h5>
                    <p class="text-muted mb-2 fw-bold">@php echo $activity->formattedDate @endphp</p>
                    <p class="text-muted">
                        {{$activity->activity}}
                    </p>
                    <small>
                        Created By: {{$activity->getAddedBy->first_name}} {{$activity->getAddedBy->last_name}}
                    </small>
                </li>
                @endforeach
            </ul>
        </section>
        <!-- Section: Timeline -->
    </div>
    <style>
        .timeline {
            border-left: 1px solid hsl(0, 0%, 90%);
            position: relative;
            list-style: none;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .timeline-item:after {
            background-color: hsl(0, 0%, 90%);
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }
    </style>



    @stop

    @section('moar_scripts')
    @include ('partials.bootstrap-table')
    @stop