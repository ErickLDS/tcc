<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MontarChurrosController extends Controller
{
    public function index () {
        return view('site.montarChurros');
    }
}
