<?php

namespace App\Models;

use App\Models\User;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, Authorizable;
    protected $fillable = ['title', 'description'];

    protected static function booted()
    {
        static::creating(function ($course) {
            $course->user_id = auth()->id();
        });
    }
    protected $appends = ['update'];

    public function getUpdateAttribute()
    {
        return $this->can('update-course', $this);
    }

    // public function getUpdateAttribute()
    // {
    //     return $this->can('update-course', $this);
    // }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
