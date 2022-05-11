<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentService
{
    public function create($request): Student
    {
        $group = Group::find($request->group_id);
        $params = $request->only(['name', 'email']);

        return DB::transaction(function () use ($params, $group) {
            $student = Student::make($params);

            $student->group()->associate($group);
            $student->saveOrFail();

            return $student;
        });
    }

    public function update($request, int $id): void
    {
        $group = Group::findOrFail($request->group_id);
        $params = [
            'name' => $request->name,
            'group_id' => $group->id,
        ];
        $student = Student::findOrFail($id);
        $student->update($params);
    }

    public function delete(int $id): void
    {
        Student::findOrFail($id)->delete();
    }
}
