<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function index()
    {
        // Redirect based on user role
        if (auth()->user()->role === 'admin') {
            return view('home-admin');
        } else {
            return view('home-clerk');
        }
    }
}
