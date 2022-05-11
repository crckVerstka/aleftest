<?php

namespace App\Services;

use App\Models\Lecture;

class LectureService
{
    public function create($request): Lecture
    {
        $params = $request->only(['topic', 'description']);

        return Lecture::create($params);
    }

    public function update($request, int $id): void
    {
        $params = $request->only(['topic', 'description']);
        $lecture = Lecture::findOrFail($id);
        $lecture->update($params);
    }

    public function delete(int $id): void
    {
        Lecture::findOrFail($id)->delete();
    }
}
