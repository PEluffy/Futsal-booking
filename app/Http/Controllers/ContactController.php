<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function showContact(Request $request)
    {
        $contact = Contact::first();
        return view('admin.pages.contact', compact('contact'));
    }
    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'phone'     => ['required', new \App\Rules\PhoneNumberRule],
            'email'     => 'required|email',
            'mapSrc'    => 'required|string',
            'facebook'  => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter'   => 'nullable|url',
        ]);

        $contact = Contact::first();

        $isSame =
            $contact->phone === $validated['phone'] &&
            $contact->email === $validated['email'] &&
            $contact->mapSrc === $validated['mapSrc'] &&
            $contact->facebook === ($validated['facebook'] ?? null) &&
            $contact->instagram === ($validated['instagram'] ?? null) &&
            $contact->twitter === ($validated['twitter'] ?? null);

        if ($isSame) {
            return back()->with('warning', 'Please change something to update.');
        }
        $contact->update([
            'phone'     => $validated['phone'],
            'email'     => $validated['email'],
            'mapSrc'    => $validated['mapSrc'],
            'facebook'  => $validated['facebook'],
            'instagram' => $validated['instagram'],
            'twitter'   => $validated['twitter'],
        ]);

        return back()->with('success', 'Contact info saved successfully!');
    }
}
