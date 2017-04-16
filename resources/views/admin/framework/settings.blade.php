@extends('admin.layout')
@section('content')

    <h2 class="nav-tab-wrapper">
        <a href="?page={{ $request->get('page') }}&tab=docs" class="nav-tab @if(!$request->has('tab') || $request->get('tab') == 'docs') nav-tab-active @endif">Documentation</a>
        <a href="?page={{ $request->get('page') }}&tab=config" class="nav-tab @if($request->get('tab') == 'config') nav-tab-active @endif">Config</a>
        <a href="?page={{ $request->get('page') }}&tab=routes" class="nav-tab @if($request->get('tab') == 'routes') nav-tab-active @endif">Routes</a>
        <a href="?page={{ $request->get('page') }}&tab=session" class="nav-tab @if($request->get('tab') == 'session') nav-tab-active @endif">Session</a>
        <a href="?page={{ $request->get('page') }}&tab=storage" class="nav-tab @if($request->get('tab') == 'storage') nav-tab-active @endif">Storage</a>
        <a href="?page={{ $request->get('page') }}&tab=cache" class="nav-tab @if($request->get('tab') == 'cache') nav-tab-active @endif">Cache</a>
    </h2>
    <div id="poststuff">

        @include('admin.parts.alert')

        @include('admin.framework.tabs.'.($request->get('tab') ? $request->get('tab') : 'docs'))
        <br class="clear">
    </div>
@endsection