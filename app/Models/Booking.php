<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'comment',
        'booking_date',
        'status',
        'approved_or_rejected_date',
        'reject_message',
        'place_id'
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
    protected $casts = [
        'booking_date' => 'datetime',
        'approved_or_rejected_date' => 'datetime'
    ];
}
