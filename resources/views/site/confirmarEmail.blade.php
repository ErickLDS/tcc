@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/confirmarEmail.css')}}">
@endsection

@section('main')
<main id="confirmarEmail">
    <ConfirmarEmail/>
</main>
@endsection

@section('js')
<script src="{{asset('js/confirmarEmail.js')}}"></script>
@endsection