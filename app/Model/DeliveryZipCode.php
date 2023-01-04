<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryZipCode extends Model
{
    use HasFactory;

    protected $fillable = ['zipcode'];
}
