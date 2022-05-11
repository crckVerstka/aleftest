<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function plan()
    {
        return $this->belongsToMany(Lecture::class,'plans')->orderBy('sort');
    }

    public function listenedLectures()
    {
        return $this->belongsToMany(Lecture::class,'listened_lecture_by_groups');
    }
}
