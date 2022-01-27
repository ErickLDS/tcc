@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/app.css')}}">
@endsection

@section('main')
<main id="app">
    <App/>
</main>
@endsection

@section('js')
<script src="{{asset('js/app.js')}}"></script>
@endsection