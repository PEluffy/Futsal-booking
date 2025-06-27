<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function reserveCourt(Request $request)
    {
        Log::info($request);

        //validate the mail of the user if the user mail is validate they can book 
        //else 
        //throw them to validation link so that they can validate 
        $user = Auth::guard('web')->user();
        if ($user->email_verified_at) {
            $validated = $request->validate([
                'date' => 'required|date|date_format:Y-m-d',
                'time' => 'required|date_format:H', // H:i → e.g., "14:00"
                'phone' => 'required|digits:10',
                'team_name' => 'string|required',
                'court_id' => 'required|exists:courts,id',
            ]);
            $validated['user_id'] = $user->id;
            $validated['status'] = \App\Enums\Status::Reserved->value;

            $alreadyBooked = Booking::where('court_id', $validated['court_id'])
                ->where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->exists();

            if ($alreadyBooked) {
                return back()->withErrors(['court_id' => 'This time slot is already booked for the selected court.']);
            }
            Booking::create($validated);

            //you can book 
        } else {
            return redirect()->route('verification.notice');
            //you cant plz go and verify your mail 
        }
    }
}
