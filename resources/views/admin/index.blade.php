@extends('layouts.app')
@section('body')
    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <!-- Stats Cards -->
            <div class="row mb-2">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title text-white">Total Users</h5>
                            <h2 class="text-white">{{ number_format($totalUsers) }}</h2>
                            <p class="mb-0"><i class="fas fa-arrow-up"></i> {{ $percentageIncrease['users'] }}% increase</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Active Bookings</h5>
                            <h2>{{ number_format($activeBookings) }}</h2>
                            <p class="mb-0"><i class="fas fa-arrow-up"></i> {{ $percentageIncrease['bookings'] }}%
                                increase</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">Listed Places</h5>
                            <h2>{{ number_format($listedPlaces) }}</h2>
                            <p class="mb-0"><i class="fas fa-arrow-up"></i> {{ $percentageIncrease['places'] }}% increase
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title">Total Reviews</h5>
                            <h2>{{ number_format($totalReviews) }}</h2>
                            <p class="mb-0"><i class="fas fa-arrow-up"></i> {{ $percentageIncrease['reviews'] }}% increase
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings Table -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bookings</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Place</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->tourist->fname }} {{ $booking->tourist->lname }}</td>
                                        <td>{{ $booking->tourist->email }}</td>
                                        <td>{{ $booking->place->name }}</td>
                                        <td>{{ $booking->booking_date->format('d M, Y H:i:s') }}</td>
                                        <td>
                                            @if ($booking->status == 'approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif ($booking->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Places and Reviews -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Top Rated Places</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach ($topRatedPlaces as $item)
                                    <a href="{{ route('places.show', $item->id) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $item->name }}</h6>
                                                <small>Category: {{ $item->category }}</small>
                                            </div>
                                            <div>
                                                <span class="badge bg-warning">{{ $item->rating }} ★</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Reviews</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @foreach ($mostReviewedPlaces as $item)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-1">{{ $item->place->name }}</h6>
                                            <small>{{ $item->rating }} ★</small>
                                        </div>
                                        <p class="mb-1">{{ $item->content }}</p>
                                        <small>By {{ $item->name }}</small>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
