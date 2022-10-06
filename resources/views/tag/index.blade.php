@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.livetracking') }}
@parent
@stop

@section('header_right')
<a href="#" class="btn btn-primary pull-right" xmlns="http://www.w3.org/1999/html">
    {{ trans('general.add-tag') }}</a>
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
    <!-- side address column -->
    <div class="col-md-3">
        <h2>Devices Information</h2>
    </div>


    <div class="col-md-9">
        <div class="box box-default">
            <div class="box-body">
                <div class="table-responsive">
                        <table
                                data-columns="{{ \App\Presenters\TagPresenter::dataTableLayout() }}"
                                data-cookie-id-table="tagTable"
                                data-pagination="true"
                                data-id-table="tagTable"
                                data-search="true"
                                data-side-pagination="server"
                                data-show-columns="true"
                                data-show-export="true"
                                data-show-refresh="true"
                                data-show-fullscreen="true"
                                data-sort-order="asc"
                                id="tagTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.tags.index') }}"
                                data-export-options='{
                        "fileName": "export-tags-{{ date('Y-m-d') }}",
                        "ignoreColumn": []
                        }'>

                        </table>
                </div>
            </div>
        </div>
    </div>

    @stop

    @section('moar_scripts')
    @include ('partials.bootstrap-table')
    @stop