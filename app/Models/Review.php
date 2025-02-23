<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'content',
        'rating',
        'is_top_rated',
        'place_id',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
