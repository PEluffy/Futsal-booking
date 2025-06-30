<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Reservation;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

use function Illuminate\Log\log;

class BookingController extends Controller
{
    public function bookCourt(Request $request)
    {
        //validate the mail of the user if the user mail is validate they can book 
        //else 
        //throw them to validation link so that they can validate 
        $user = Auth::guard('web')->user();

        $validated = $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'time' => 'required|date_format:H', // H:i → e.g., "14:00"
            'phone' => 'required|digits:10',
            'team_name' => 'string|required',
            'court_id' => 'required|exists:courts,id',
        ]);
        $validated['user_id'] = $user->id;

        $alreadyBooked = Booking::where('court_id', $validated['court_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['court_id' => 'This time slot is already booked for the selected court.']);
        }
        Booking::create($validated);
    }
    public function reserveCourt(Request $request)
    {
        Log::info(Carbon::now()->setTimezone('Asia/Kathmandu')->addMinutes(10));
        Log::info(Carbon::now()->setTimezone('Asia/Kathmandu'));
        Log::info($request);
        $user = Auth::guard('web')->user();
        $validated = $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'time' => 'required|date_format:H', // H:i → e.g., "14:00"
            'court_id' => 'required|exists:courts,id',
        ]);
        $validated['user_id'] = $user->id;

        //todo
        // if there is another time reserved in the same user id then remove that id and update or add another one ->if user exist in the reservation table dont check and the 

        $reserved = Reservation::where('court_id', $validated['court_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->where('reserved_at', '>', Carbon::now()->setTimezone('Asia/Kathmandu')->subMinutes(10))->exists();

        // if the time -10 min is greater than the reserve time than update the user that has reserved the court with current user id and current reserve date

        if ($reserved) {
            return response()->json(['message' => 'This slot is temporarily reserved by another user.'], 409);
        }
        Reservation::updateOrCreate(
            [
                'user_id' => $user->id,
                'court_id' => $request->court_id,
                'date' => $request->date,
                'time' => $request->time,
            ],
            ['reserved_at' => Carbon::now()->setTimezone('Asia/Kathmandu')]
        );

        return response()->json(['message' => 'Slot reserved successfully']);
    }
}
