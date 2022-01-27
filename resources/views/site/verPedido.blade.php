@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/verPedido.css')}}">
@endsection

@section('main')
<main id="verPedido">
    <VerPedido/>
</main>
@endsection

@section('js')
<script src="{{asset('js/verPedido.js')}}"></script>
@endsection