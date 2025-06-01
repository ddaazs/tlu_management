<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->only('home');
    }

    public function redirectHome(){
        redirect()->route('home');
    }

    public function returnHome(){
        return view('page.home');
    }
}
