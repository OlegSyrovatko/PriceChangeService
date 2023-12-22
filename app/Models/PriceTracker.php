<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceTracker extends Model
{
    protected $fillable = ['url', 'current_price', 'email', 'is_verified'];
}
