@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/finalizar.css')}}">
@endsection

@section('main')
<main id="finalizar">
    <Finalizar/>
</main>
@endsection

@section('js')
<script src="{{asset('js/finalizar.js')}}"></script>
@endsection