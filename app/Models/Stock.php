<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Stock extends Model
{
    use HasFactory;

    protected $table = "stock";
    protected $primaryKey = "book_isbn_no";
    protected $keyType = "string";
    public $incrementing = false;

    public function comments($id = null) {
        if (is_null($id))
            return $this->hasMany(Comment::class, "isbn")->orderBy("created_at", "desc");
        else
            return $this->hasMany(Comment::class, "isbn")->where("user_id", "!=", $id)->orderBy("created_at", "desc");
    }
}
