<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function reserveCourt(Request $request)
    {
        Log::info($request);
        Log::info(Auth::guard('web')->user());
    }
}
