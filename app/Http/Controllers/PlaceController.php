<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::orderByDesc('id')->get();
        return view('admin.places', compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:4|unique:places,name',
            'category' => 'required',
            'price' => 'required|integer|min:0',
            'short_description' => 'required',
            'long_description' => 'required',
            'image_file' => 'required|mimes:jpeg,png,jpg|max:2048',
            'rating' => 'required|in:1,2,3,4,5',
            'status' => 'required|in:active,inactive',
        ]);
        try {
            if ($request->hasFile('image_file')) {
                $image_url = $request->file('image_file')->store('places', 'public');
                $request->merge(['image' => $image_url]);
            }
            Place::create($request->all());
            return back()->with('message', 'Place added succesfully');
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        $reviews = Review::where('place_id', $place->id)->orderByDesc('id')->get();
        return view('admin.show-place', compact('place', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        $request->validate([
            'name' => 'required|string|min:4|unique:places,name,' . $place->id,
            'category' => 'required',
            'price' => 'required|integer|min:0',
            'short_description' => 'required',
            'long_description' => 'required',
            'image_file' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'rating' => 'required|in:1,2,3,4,5',
            'status' => 'required|in:active,inactive',
        ]);
        try {
            if ($request->hasFile('image_file')) {
                Storage::delete($place->image);
                $image_url = $request->file('image_file')->store('places', 'public');
                $request->merge(['image' => $image_url]);
            }
            $place->update($request->all());
            return back()->with('message', 'Place updated succesfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        try {
            Storage::delete($place->image);
            $place->delete();
            return back()->with('message', 'Place deleted succesfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
    public function disactive_review(Review $review)
    {
        try {

            $review->update(['is_top_rated' => false]);
            return back()->with('message', 'Review disactived succesfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', $th->getMessage());
        }
    }
}
