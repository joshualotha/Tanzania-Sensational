<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return response()->json(ContactSubmission::latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'objective' => 'required|string',
            'vision' => 'nullable|string',
        ]);

        $submission = ContactSubmission::create($validated);

        return response()->json([
            'message' => 'Your expedition architectural brief has been received. Our senior concierge will respond within 24 hours.',
            'id' => $submission->id
        ], 201);
    }
    public function destroy($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->delete();
        return response()->json(null, 204);
    }
}
