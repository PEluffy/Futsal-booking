<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Court;
use App\Models\Facility;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function showIndex()
    {
        $courts = Court::take(3)->get();
        $facilities = Facility::take(4)->get();
        return view('welcome', compact('courts', 'facilities'));
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
        $facilities = Facility::all();
        return view('pages.facilities', compact('facilities'));
    }
    public function showCourts(Request $request)
    {
        $query = Court::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('type')) {
            $query->where('type', '=', $request->type);
        }

        $courts = $query->paginate(3)->appends(request()->query());
        Log::info($courts);
        $facilities = Facility::all();
        return view('pages.courts', compact('courts', 'facilities'));
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
