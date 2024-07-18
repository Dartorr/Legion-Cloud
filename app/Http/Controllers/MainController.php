<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    function auth(){
        return view('auth');
    }

    function reg(){
        return view('reg');
    }

    function downloadFile(Request $request){
        return Storage::download($request->all()['url']);
    }

    function filter(){
        return view('filter');
    }
}
