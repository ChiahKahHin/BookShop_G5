<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = "stock";
    protected $primaryKey = "book_isbn_no";
    protected $keyType = "string";
    public $incrementing = false;
}
