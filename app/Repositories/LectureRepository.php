<?php

namespace App\Repositories;

use App\Models\Lecture as Model;

class LectureRepository extends BaseRepository
{
    public function getAll()
    {
        return $this->startCondition()->all();
    }

    public function show(int $id)
    {
        return $this->startCondition()->with('studentListeners', 'groupListeners')->findOrFail($id);
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
