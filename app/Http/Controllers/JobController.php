<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Services\JobService;

class JobController extends Controller
{
    protected JobService $jobService;

    public function __construct(JobService $jobService){
        $this->jobService = $jobService;
    }

    public function index()
    {
        return response()->json(["test"]);
    }

    public function create(JobRequest $request)
    {
        try {
            // validate
            $data = $request->validated();

            // insert new job
            $job = $this->jobService->createJob($data);

            return response()->json([
                'message' => 'Job added successfully',
                'data' => $job
            ], 201);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating job',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
