<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'venue_id', 
        'start_time', 
        'end_time', 
        'organizer'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
