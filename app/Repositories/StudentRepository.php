<?php

namespace App\Repositories;

use App\Models\Student as Model;

class StudentRepository extends BaseRepository
{
    public function getAll()
    {
        return $this->startCondition()->all();
    }

    public function show(int $id)
    {
        return $this->startCondition()->with('group', 'listenedLectures')->findOrFail($id);
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
