@extends('site.template')

@section('main')
<main id="politicas">
    <Politicas/>
</main>
@endsection

@section('js')
<script src="{{asset('js/politicas.js')}}"></script>
@endsection