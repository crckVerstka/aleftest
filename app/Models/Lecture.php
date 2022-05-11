<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $fillable = ['topic', 'description'];

    public function studentListeners()
    {
        return $this->belongsToMany(Student::class,'listened_lecture_by_students');
    }

    public function groupListeners()
    {
        return $this->belongsToMany(Group::class,'listened_lecture_by_groups');
    }
}
