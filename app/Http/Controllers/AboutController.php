<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about_get(Request $request) {
      return view('pages/about');
    }
}
