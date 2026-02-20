<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = ['name', 'email', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
}
