<?php

namespace App\Http\Controllers;

use App\Enums\CourtType;
use App\Models\Court;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CourtsController extends Controller
{
    public function showCourts()
    {
        $courts = Court::with('facilities')->get();
        $facilities = Facility::all();
        return view('admin.pages.courts', compact('courts', 'facilities'));
    }

    public function createCourt(Request $request)
    {
        Log::info($request);
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'type' => ['required', Rule::in(array_column(CourtType::cases(), 'value'))],
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ]);
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('image/courts'), $imageName);
        $court = Court::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' =>  $imageName,
            'type' => $request->type,
        ]);
        if ($request->has('facilities')) {
            $court->facilities()->sync($request->facilities); // saves to pivot
        }
        $court->save();
        return redirect()->route('admin.courts')->with('success', 'Court created successfully.');
    }
}
