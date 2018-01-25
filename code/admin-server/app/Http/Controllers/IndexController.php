<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        return view('index.index');
    }

    public function info() {
        return view('info');
    }
}
