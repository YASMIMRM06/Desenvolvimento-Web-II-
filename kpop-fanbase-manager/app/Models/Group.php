<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'debut_date', 'company', 'description', 'photo'];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}