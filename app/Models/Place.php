<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category',
        'price',
        'short_description',
        'long_description',
        'image',
        'rating',
        'status',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_top_rated', 1);
    }

}
