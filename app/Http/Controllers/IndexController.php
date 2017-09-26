<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
  public function index_get(Request $request) {
    return view('pages/index');
  }
}
