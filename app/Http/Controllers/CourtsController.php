<?php

namespace App\Http\Controllers;

use App\Enums\CourtType;
use App\Models\Court;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Type\Integer;

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

    public function deleteCourt(Request $request,  $id)
    {
        $court = Court::find($id);
        $court->delete();
        File::delete(public_path('image/courts/' . $court->image));
    }
    public function updateCourt(Request $request, $courtId)
    {
        $court = Court::findOrFail($courtId);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'price' => 'required|numeric',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        $court->name = $request->name;
        $court->type = $request->type;
        $court->price = $request->price;
        $facilityIds = $validated['facilities'] ?? [];
        $court->facilities()->sync($facilityIds);
        // if request has image on it update image form databaaseand delete the file that the old data is pointing to 
        if ($request->hasFile('image')) {
            $imageSrc = $court->image;
            $file_path = public_path('image/courts/' . $imageSrc);
            if (File::exists($file_path)) {
                Log::info('file deleted');
                File::delete($file_path);
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image/courts'), $imageName);
            $court->image = $imageName;
        }
        $court->save();
        $updatedCourt = $court->fresh()->load('facilities');
        return response()->json(
            [
                'court' => $updatedCourt,
            ],
            200
        );
    }
}
