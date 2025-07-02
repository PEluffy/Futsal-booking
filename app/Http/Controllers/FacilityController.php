<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

use function Laravel\Prompts\error;

class FacilityController extends Controller
{
    public function showFacility()
    {
        $facilities = Facility::all();
        return view('admin.pages.facility', compact('facilities'));
    }
    public function createFacility(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'desc' => 'required',
        ]);

        try {
            $filename = $request->name . '.svg';
            Log::info($request->name);

            $filePath = public_path('image/svg/' . $filename);
            Log::info($filePath);
            file_put_contents($filePath, $request->icon);
            $facility = Facility::create(['name' => $request->name, 'desc' => $request->desc]);
            return response()->json(
                [
                    'facility' => $facility,
                ],
                200
            );
        } catch (Error) {
            return Response::json('Something went wrong');
        }
    }
}
