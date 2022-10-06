@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.livetracking') }}
@parent
@stop

@section('header_right')
<a href="#" class="btn btn-primary pull-right" xmlns="http://www.w3.org/1999/html">
    {{ trans('general.create-geofence') }}</a>
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
        <h2>Filter Assets</h2>

    </div>


    <div class="col-md-9">
        <div class="box box-default">
            <div class="box-body">
                <div class="table-responsive">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

    @stop

    @section('moar_scripts')
    @include ('partials.bootstrap-table')
    @stop
    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8s4KqoMeyInrL_Gghw5dzEK8_O2UgnLA&callback=initMap&v=weekly"
            defer
    ></script>
    <script>

        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            const uluru = { lat: -1.282256, lng: 36.7093359 };
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 8,
                center: uluru,
            });
            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
                position: uluru,
                map: map,
            });
        }

        window.initMap = initMap;
    </script>