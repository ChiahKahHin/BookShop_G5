<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;
    protected $table = "checkout";
    protected $primaryKey = "checkoutID";

    protected $fillable = [
        'user_id',
        'total_price',
        'address',
        'status'
    ];
}
