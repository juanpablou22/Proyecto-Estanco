<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Dashboard protegido por auth
     */
    public function index()
    {
        
        return view('home'); 
    }
}

