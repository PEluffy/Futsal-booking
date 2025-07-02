<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function showFacility()
    {
        $facilities = Facility::all();
        return view('admin.pages.facility', compact('facilities'));
    }
}
