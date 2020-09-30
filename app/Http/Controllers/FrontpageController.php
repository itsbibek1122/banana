<?php

namespace App\Http\Controllers;

use App\Property;
use App\Http\Controllers\Controller;

class FrontpageController extends Controller
{

    public function index()
    {
        $properties = Property::latest()->where('featured', 1)->get();

        return view('frontend.index', compact('properties'));
    }
}
