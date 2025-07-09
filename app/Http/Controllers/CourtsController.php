<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Enums\CourtType;
use App\Models\Court;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
    public function showCourtDetails($slug)
    {
        $court = Court::with('facilities')->where('slug', $slug)->firstOrFail();
        return view('pages.single-court-details', compact('court'));
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
        //making slug unique
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Court::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('image/courts'), $imageName);
        $court = Court::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' =>  $imageName,
            'type' => $request->type,
            'slug' => $slug,
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
        return redirect()->back()->with('success', 'Court deleted successfull');
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

        if ($court->isDirty('name')) {
            $newSlug = Str::slug($request->name);
            $originalSlug = $newSlug;
            $count = 1;
            while (Court::where('slug', $newSlug)->where('id', '!=', $court->id)->exists()) {
                $newSlug = $originalSlug . '-' . $count++;
            }
            $court->slug = $newSlug;
        }

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
    public function searchCourts(Request $request)
    {
        $name = $request->query('name');
        $maxPrice = $request->query('price_max');
        Log::info($maxPrice);


        $courts = DB::table('courts')
            ->whereRaw("name LIKE ?", ["%{$name}%"])
            ->whereRaw('price < ?', [$maxPrice])
            ->get();

        Log::info($courts);
        return response()->json(['courts' => $courts], 200);
    }
}
