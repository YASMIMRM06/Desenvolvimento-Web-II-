<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'title', 'duration', 'release_date', 'youtube_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function updateAverageRating()
    {
        $this->average_rating = $this->ratings()->avg('rating');
        $this->save();
    }
}
