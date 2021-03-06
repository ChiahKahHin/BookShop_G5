<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "isbn",
        "rating",
        "content",
        "mimeType",
        "attachment"
    ];

    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }

    public function stock() {
        return $this->belongsTo(Stock::class, "isbn");
    }
}
