<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Plan;
use App\Repositories\GroupRepository;
use App\Services\GroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    private $groupRepository;
    private $groupService;
    public function __construct(GroupRepository $groupRepository, GroupService $groupService)
    {
        $this->groupRepository = $groupRepository;
        $this->groupService = $groupService;
    }
    public function plan($group_id)
    {
        return $this->groupRepository->getPlan($group_id);
    }

    public function createOrUpdatePlan(Request $request)
    {
        $params = [
            'group_id' => $request->group_id,
            'lectures' => $request->lectures,
        ];
        $plan = $this->groupService->createOrUpdatePlan($params);

//        $group->plan()->sync($params['lectures']);

        return response()->json(['data' => true], Response::HTTP_CREATED);
    }
}
