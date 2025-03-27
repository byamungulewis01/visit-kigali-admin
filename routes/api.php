<?php

use App\Models\Place;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Tourist;
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


Route::post('/register', function (Request $request) {
    try {
        // Validate request data
        $request->validate([
            'fname' => 'required|string|min:2|max:255',
            'lname' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:tourists,email',
            'phone' => 'required|string|min:10|max:15|unique:tourists,phone',
            'date_of_birth' => 'required|date|before:today',
            'nationality' => 'required|string',
        ]);

        $tourist = Tourist::create($request->all());

        // Success response
        return response()->json([
            'message' => 'Tourist registered successfully!',
            'data' => $tourist
        ], 201);
    } catch (ValidationException $e) {
        // Return validation errors in JSON format
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    }
});

Route::post('/search-tourist', function (Request $request) {
    try {
        // Validate request data
        $request->validate([
            'search_term' => 'required|string|min:3',
        ]);

        $searchTerm = $request->search_term;

        // Search for tourist by email or phone
        $tourist = Tourist::where('email', $searchTerm)
                          ->orWhere('phone', $searchTerm)
                          ->first();

        if ($tourist) {
            // Tourist found
            return response()->json([
                'message' => 'Tourist found!',
                'data' => $tourist
            ], 200);
        } else {
            // Tourist not found
            return response()->json([
                'message' => 'No tourist found with the provided email or phone',
            ], 404);
        }
    } catch (Exception $e) {
        // Return error in JSON format
        return response()->json([
            'message' => 'Error searching for tourist',
            'error' => $e->getMessage()
        ], 500);
    }
});


Route::post('/booking/{id}', function (Request $request, $id) {
    try {
        // Validate request data
        $validated = $request->validate([
            'tourist_id' => 'required|exists:tourists,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'comment' => 'nullable|string',
        ]);

        // Create booking
        $booking = Booking::create([
            'tourist_id' => $validated['tourist_id'],
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
// Route::post('/booking/{id}', function (Request $request, $id) {
//     try {
//         // Validate request data
//         $validated = $request->validate([
//             'name' => 'required|string|min:4|max:255',
//             'email' => 'required|email',
//             'booking_date' => 'required|date|after_or_equal:today',
//             'comment' => 'nullable|string',
//         ]);

//         // Create booking
//         $booking = Booking::create([
//             'name' => $validated['name'],
//             'email' => $validated['email'],
//             'comment' => $validated['comment'],
//             'booking_date' => $validated['booking_date'],
//             'place_id' => $id
//         ]);

//         // Success response
//         return response()->json([
//             'message' => 'Booking request submitted successfully!',
//             'data' => $booking
//         ], 201);
//     } catch (ValidationException $e) {
//         // Return validation errors in JSON format
//         return response()->json([
//             'message' => 'Validation failed',
//             'errors' => $e->errors()
//         ], 422);
//     }
// });

Route::post('/review/{id}', function (Request $request, $id) {
    try {
        $validated = $request->validate([
            'email' => 'required|email|exists:tourists,email',
            'content' => 'required|string',
            'rating' => 'required|in:1,2,3,4,5',
        ]);
        $tourist = Tourist::where('email', $validated['email'])->first();


        $review = Review::create([
            'tourist_id' => $tourist->id,
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
