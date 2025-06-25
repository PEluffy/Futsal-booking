<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Court;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showIndex()
    {
        $courts = Court::all();
        return view('welcome', compact('courts'));
    }
    public function showBooking()
    {
        $courts = Court::all();
        return view('pages.booking', compact('courts'));
    }
    public function showAbout()
    {
        $contact = Contact::first();
        return view('pages.about', compact('contact'));
    }

    public function showFacilities()
    {
        return view('pages.facilities');
    }
    public function showCourts()
    {
        $courts = Court::all();
        return view('pages.courts', compact('courts'));
    }
    public function showLogin()
    {
        return view('pages.login');
    }
    public function showRegister()
    {
        return view('pages.register');
    }
}
