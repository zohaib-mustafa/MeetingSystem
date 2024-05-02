<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

     protected $fillable = [
        'subject',
        'datetime',
        'creator_id',
        'google_calendar_event_id',
        'google_calendar_event',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
