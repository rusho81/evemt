<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    function FrontPage() {
        return view('pages.front.home-view');
    }
    
    function ListPost (Request $request) {
        return Event::get();
    }
}
