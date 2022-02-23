@extends('layouts.backend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="app">
            <router-view></router-view>
            <!-- <user-index></user-index> -->
            <!-- <example-component></example-component> -->
        </div>
    </div>
</div>
@endsection