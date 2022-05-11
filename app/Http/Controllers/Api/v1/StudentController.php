<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Repositories\StudentRepository;
use App\Services\StudentService;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    private $repository;
    private $service;
    public function __construct(StudentRepository $repository, StudentService $service)
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
        $students = $this->repository->getAll();

        return StudentResource::collection($students);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StudentRequest $request)
    {
        $student = $this->service->create($request);

        return response()->json(['data' => $student], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return StudentResource
     */
    public function show(int $id)
    {
        $student = $this->repository->show($id);

        return new StudentResource($student);
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
