<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $title = 'Home';
        return view('home.index', compact('title'));
    }
    public function about()
    {
        $title = 'About Us';
        return view('home.about', compact('title'));
    }
    public function contact()
    {
        $title = 'Contact Us';
        return view('home.contact', compact('title'));
    }
    public function services()
    {        $title = 'Our Services';
        return view('home.services', compact('title'));
    }
    public function blog()
    {
        $title = 'Blog';
        return view('home.blog', compact('title'));
    }
    public function blogSingle()
    {
        $title = 'Blog Single';
        return view('home.blog-single', compact('title'));
    }
    public function portfolio()
    {
        $title = 'Portfolio';
        return view('home.portfolio', compact('title'));
    }
    public function team()
    {
        $title = 'Team';
        return view('home.team', compact('title'));
    }
    public function pricing()
    {
        $title = 'Pricing';
        return view('home.pricing', compact('title'));
    }
}
