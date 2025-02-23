<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Place;
use App\Models\Review;
use App\Models\Booking;

class DashboardController extends Controller
{

    public function index()
    {
        $totalUsers = User::count();
        $activeBookings = Booking::where('status', 'pending')->count();
        $listedPlaces = Place::count();
        $totalReviews = Review::count();

        // Example: Fetch percentage increase (dummy values for now)
        $percentageIncrease = [
            'users' => 12,
            'bookings' => 8,
            'places' => 15,
            'reviews' => 10,
        ];

        $bookings = Booking::orderBy('id', 'desc')->limit(5)->get();
        $topRatedPlaces = Place::orderBy('rating', 'desc')->limit(5)->get();
        $mostReviewedPlaces = Review::orderBy('id', 'desc')->limit(3)->get();
        return view('admin.index', compact('totalUsers', 'activeBookings', 'listedPlaces', 'totalReviews', 'percentageIncrease', 'bookings', 'topRatedPlaces', 'mostReviewedPlaces'));
    }
}
