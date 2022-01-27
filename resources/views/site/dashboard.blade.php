@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endsection

@section('main')
<main id="dashboard">
    <Dashboard/>
</main>
@endsection

@section('js')
<script src="{{asset('js/dashboard.js')}}"></script>
@endsection