<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function listenedLectures()
    {
        return $this->belongsToMany(Lecture::class,'listened_lecture_by_students');
    }
}
