<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display the client home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('client.home');
    }
}