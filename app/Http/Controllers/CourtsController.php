<?php

namespace App\Http\Controllers;

use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourtsController extends Controller
{
    public function showCourts()
    {
        $courts = Court::all();
        return view('admin.pages.courts', compact('courts'));
    }

    public function createCourt(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('image/courts'), $imageName);
        $court = Court::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' =>  $imageName,
        ]);
        $court->save();
        return redirect()->route('admin.courts')->with('success', 'Court created successfully.');
    }
}
