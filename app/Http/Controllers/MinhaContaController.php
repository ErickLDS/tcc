<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinhaContaController extends Controller
{
    public function index () {
        return view('site.minhaConta');
    }

    public function indexPedido () {
        return view('site.verPedido');
    }
}
