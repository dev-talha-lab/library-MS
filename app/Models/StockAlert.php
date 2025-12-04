<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAlert extends Model
{
    use HasFactory;

    protected $fillable = ['book_id','copies_at_alert','alerted_at'];

    protected $casts = [
        'alerted_at' => 'datetime',
    ];

    public function book(){
        return $this->belongsTo(Book::class);
    }
}
