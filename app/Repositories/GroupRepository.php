<?php

namespace App\Repositories;

use App\Models\Group as Model;

class GroupRepository extends BaseRepository
{
    public function getAll()
    {
        return $this->startCondition()->all();
    }

    public function show(int $id)
    {
        return $this->startCondition()->with('students')->findOrFail($id);
    }

    public function getPlan(int $id)
    {
        return $this->startCondition()->findOrFail($id)->plan;
    }

    protected function getModelClass()
    {
        return Model::class;
    }
}
