<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroSliders = \App\Models\HeroSlider::active()->ordered()->get();
        $homeSections = \App\Models\HomeSection::active()->ordered()->with('contents')->get();
        
        return view('home', compact('heroSliders', 'homeSections'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function services()
    {
        return view('services');
    }
}