@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/login.css')}}">
@endsection

@section('main')
<main id="login">
    <Login/>
</main>
@endsection

@section('js')
<script src="{{asset('js/login.js')}}"></script>
@endsection