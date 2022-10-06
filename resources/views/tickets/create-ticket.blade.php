@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.new-ticket') }}
@parent
@stop
@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right" xmlns="http://www.w3.org/1999/html">
    {{ trans('general.back') }}</a>
@stop
{{-- Account page content --}}
@section('content')

<section class="content" id="main" tabindex="-1">

    <!-- Notifications -->
    <div class="row">

    </div>


    <!-- Content -->
    <div id="webui">

        <!-- row -->
        <div class="row">
            <!-- col-md-8 -->
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

                <form id="create-form" class="form-horizontal has-validation-callback" method="post" action="{{route('save-ticket')}}" autocomplete="off" role="form" enctype="multipart/form-data">

                    <!-- box -->
                    <div class="box box-default">
                        <!-- box-header -->
                        <div class="box-header with-border text-right">

                            <div class="col-md-12 box-title text-right" style="padding: 0px; margin: 0px;">

                                <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                    <div class="col-md-9 text-left">
                                    </div>
                                    <div class="col-md-3 text-right" style="padding-right: 10px;">
                                        <a class="btn btn-link text-left" href="{{route('view-tickets')}}">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check icon-white" aria-hidden="true"></i>
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /.box-header -->

                        <!-- box-body -->
                        <div class="box-body">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <!-- Name -->
                            <div class="form-group ">
                                <label for="subject" class="col-md-3 control-label">Subject</label>
                                <div class="col-md-7 col-sm-12 required">
                                    <input class="form-control" type="text" name="subject" aria-label="subject" id="subject" value="" data-validation="required" required="">

                                </div>
                            </div>
                            <!-- Asset Model -->
                            @include ('partials.forms.edit.asset-select', ['translated_name' => 'Asset', 'fieldname' => 'asset'])
                            <!-- full company support is enabled or this user is a priority -->
                            <div id="company_id" class="form-group">
                                <label for="priority_id" class="col-md-3 control-label">Priority</label>
                                <div class="col-md-7">
                                    <select class="form-control select2" data-placeholder="Select Priority" name="priority" style="width: 100%" id="priority" data-select2-id="priority_select" tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="7">Select Priority</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="high">High</option>
                                        <option value="medium">Medium</option>
                                        <option value="low">Low</option>
                                    </select>
                                </div>



                            </div>
                            <!-- Manager -->
                            @include ('partials.forms.edit.user-select', ['translated_name' => 'Assigned To', 'fieldname' => 'user'])

                            <!-- full company support is enabled or this user is a priority -->
<!--                            <div id="company_id" class="form-group">-->
<!--                                <label for="priority_id" class="col-md-3 control-label">Priority</label>-->
<!--                                <div class="col-md-7">-->
<!--                                    <select class="form-control select2" data-placeholder="Select Priority" name="priority_id" style="width: 100%" id="priority_select" data-select2-id="priority_select" tabindex="-1" aria-hidden="true">-->
<!--                                        <option value="" data-select2-id="7">Select Reason</option>-->
<!--                                        <option value="urgent">Urgent</option>-->
<!--                                        <option value="high">High</option>-->
<!--                                        <option value="medium">Medium</option>-->
<!--                                        <option value="low">Low</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!---->
<!---->
<!---->
<!--                            </div>-->
                            <!-- Serial-->
                            <div class="form-group ">
                                <label for="serial" class="col-md-3 control-label">Description</label>
                                <div class="col-md-7">
                                    <textarea class="form-control" type="text" name="description" id="description"></textarea>

                                </div>
                            </div>


                            <div class="box-footer text-right">
                                <a class="btn btn-link text-left" href="{{route('view-tickets')}}">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check icon-white" aria-hidden="true"></i> Save</button>
                            </div>
                            <!-- / partials/forms/edit/submit.blade.php -->

                        </div> <!-- ./box-body -->
                    </div> <!-- box -->
                </form>
            </div> <!-- col-md-8 -->

        </div><!-- ./row -->

    </div>

</section>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop