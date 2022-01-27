@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/loginAdm.css')}}">
@endsection

@section('main')
<main id="loginAdm">
    <LoginAdm/>
</main>
@endsection

@section('js')
<script src="{{asset('js/loginAdm.js')}}"></script>
@endsection