<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Mail\BookingStatusMail;
use Illuminate\Support\Facades\Mail;

class BookingRequestController extends Controller
{
    //
    public function pending_booking(Request $request)
    {
        $query = Booking::where('status', 'pending');

        // Date range filtering
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('booking_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $bookings = $query->orderByDesc('id')->get();
        return view('bookings.pending', compact('bookings'));
    }
    public function approved_booking(Request $request)
    {
        $query = Booking::where('status', 'approved');
        // Date range filtering
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('booking_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $bookings = $query->orderByDesc('id')->get();
        return view('bookings.approved', compact('bookings'));
    }
    public function rejected_booking(Request $request)
    {
        $query = Booking::where('status', 'rejected');
        // Date range filtering
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('booking_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $bookings = $query->orderByDesc('id')->get();
        return view('bookings.rejected', compact('bookings'));
    }
    public function booking_approve(Booking $booking)
    {
        $booking->update([
            'status' => 'approved',
            'approved_or_rejected_date' => now()
        ]);

        // Send approval email
        Mail::to($booking->email)->send(new BookingStatusMail($booking, 'Your booking has been successfully approved.'));

        return back()->with('message', "Request Approved Successfully");
    }
    public function booking_reject(Request $request, Booking $booking)
    {
        $booking->update([
            'status' => 'rejected',
            'reject_message' => $request->reject_message,
            'approved_or_rejected_date' => now()
        ]);

        // Send rejection email
        Mail::to($booking->email)->send(new BookingStatusMail($booking, $request->reject_message));

        return back()->with('message', "Request Rejected Successfully");
    }

}
