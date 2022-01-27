@extends('site.template')

@section('css')
<link rel="stylesheet" href="{{asset('css/redefinirSenha.css')}}">
@endsection

@section('main')
<main id="redefinirSenha">
    <RedefinirSenha/>
</main>
@endsection

@section('js')
<script src="{{asset('js/redefinirSenha.js')}}"></script>
@endsection