<?php

namespace App\Services;

use App\Models\Group;
use App\Models\Plan;

class GroupService
{
    public function create($request): Group
    {
        $params = $request->only(['name']);
        $group = Group::create($params);

        return $group;
    }

    public function update($request, int $id): void
    {
        $params = $request->only(['name']);
        $group = Group::findOrFail($id);
        $group->update($params);
    }

    public function delete(int $id): void
    {
        Group::findOrFail($id)->delete();
    }

    public function createOrUpdatePlan($params)
    {
        $group = Group::findOrFail($params['group_id']);
        $group->plan()->sync($params['lectures']);

        return true;
    }
}
