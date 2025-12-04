<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title','author','isbn','published_year','copies_available'];

    protected $casts = [
        'copies_available' => 'integer',
        'published_year' => 'integer',
    ];

    public function setTitleAttribute($value){
        $this->attributes['title'] = Str::of($value)->lower()->ucfirst()->value();
    }

    public function setIsbnAttribute($value){
        $digits = preg_replace('/\D+/', '', (string)$value);
        $this->attributes['isbn'] = $digits;
    }

    public function getFormattedIsbnAttribute(){
        $d = $this->isbn ?? '';
        return substr($d,0,3).'-'.substr($d,3,3).'-'.substr($d,6,6).'-'.substr($d,12,1);
    }

    public function setCopiesAvailableAttribute($value){
        $this->attributes['copies_available'] = max(0, (int)$value);
    }

    public function borrowRecords(){
        return $this->hasMany(BorrowRecord::class);
    }

    public function activityLogs(){
        return $this->hasMany(BookActivityLog::class);
    }

    public function stockAlerts(){
        return $this->hasMany(StockAlert::class);
    }
}
