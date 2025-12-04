<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','membership_id'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = Str::title($value);
    }

    public function borrowRecords(){
        return $this->hasMany(BorrowRecord::class);
    }
}
