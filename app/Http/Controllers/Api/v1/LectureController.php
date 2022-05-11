<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Repositories\LectureRepository;
use App\Services\LectureService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LectureController extends Controller
{
    private $repository;
    private $service;
    public function __construct(LectureRepository $repository, LectureService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $groups = $this->repository->getAll();

        return LectureResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $lecture = $this->service->create($request);

        return response()->json(['data' => $lecture], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return LectureResource
     */
    public function show(int $id)
    {
        $lecture = $this->repository->show($id);

        return new LectureResource($lecture);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $this->service->update($request, $id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->service->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
