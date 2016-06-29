<?php

namespace WWW\Http\Controllers;

use Illuminate\Http\Request;

use WWW\Http\Requests;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

}
