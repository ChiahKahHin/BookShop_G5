<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkoutitems extends Model
{
    use HasFactory;
    protected $table = "checkout_items";

    protected $fillable = [
        'checkoutID',
        'book_isbn_no',
        'book_quantity'
    ];

    public function books() {
        return $this->belongsTo(Stock::class, "book_isbn_no");
    }
}