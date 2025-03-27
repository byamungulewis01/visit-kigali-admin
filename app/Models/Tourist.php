<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourist extends Model
{
    use HasFactory;
    protected $fillable = ['fname', 'lname', 'email', 'phone', 'date_of_birth', 'nationality'];
}
