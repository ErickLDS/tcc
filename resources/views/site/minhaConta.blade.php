@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/minhaConta.css')}}">
@endsection

@section('main')
<main id="minhaConta">
    <MinhaConta />
</main>
@endsection

@section('js')
<script src="{{asset('js/minhaConta.js')}}"></script>
@endsection