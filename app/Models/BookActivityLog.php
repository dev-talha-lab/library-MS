<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['book_id','action'];

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
