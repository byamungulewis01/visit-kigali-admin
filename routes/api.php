<?php

use App\Models\Place;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/places', function () {
    $places = Place::where('status', 'active')->select('id', 'name', 'category', 'price', 'short_description', 'image', 'rating')->get();
    return response()->json($places);
});
Route::get('/places/{id}', function ($id) {
    $place = Place::with('reviews')->findOrFail($id);
    return response()->json($place);
});


Route::post('/booking/{id}', function (Request $request, $id) {
    try {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|email',
            'booking_date' => 'required|date|after_or_equal:today',
            'comment' => 'nullable|string',
        ]);

        // Create booking
        $booking = Booking::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'comment' => $validated['comment'],
            'booking_date' => $validated['booking_date'],
            'place_id' => $id
        ]);

        // Success response
        return response()->json([
            'message' => 'Booking request submitted successfully!',
            'data' => $booking
        ], 201);
    } catch (ValidationException $e) {
        // Return validation errors in JSON format
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    }
});
Route::post('/review/{id}', function (Request $request, $id) {
    try {
        $validated = $request->validate([
            'name' => 'required|string|min:4|max:255',
            'email' => 'required|email',
            'content' => 'required|string',
            'rating' => 'required|in:1,2,3,4,5',
        ]);

        $review = Review::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'place_id' => $id
        ]);

        // Success response
        return response()->json([
            'message' => 'Review submitted successfully!',
            'data' => $review
        ], 201);
    } catch (ValidationException $e) {
        // Return validation errors in JSON format
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    }
});
