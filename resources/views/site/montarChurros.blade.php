@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/montarChurros.css')}}">
@endsection

@section('main')
<main id="montarChurros">
    <MontarChurros/>
</main>
@endsection

@section('js')
<script src="{{asset('js/montarChurros.js')}}"></script>
@endsection