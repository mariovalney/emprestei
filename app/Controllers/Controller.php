<?php

namespace App\Controllers;

use App\Http\Request;
use App\Support\Facades\Response;

class Controller
{
    public function index(Request $request)
    {
        return Response::view('index');
    }
}
