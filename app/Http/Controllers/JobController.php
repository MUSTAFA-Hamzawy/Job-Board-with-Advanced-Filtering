<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Job;
use App\Models\Language;
use App\Models\Location;
use App\Services\JobFilterService;
use App\Services\JobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    protected JobService $jobService;

    public function __construct(JobService $jobService){
        $this->jobService = $jobService;
    }

    public function index(Request $request, JobFilterService $jobFilterService)
    {
        try {
            $jobs = $jobFilterService->applyFilters($request)->paginate(10);
            return response()->json([
                'message' => 'Job retrieved successfully',
                'data' => $jobs->toArray()
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching jobs', 'message' => $e->getMessage()], 500);
        }
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

    public function add()
    {
        // Fetch locations, languages, categories, and attributes from the API
        $locations = Location::all();
        $languages = Language::all();
        $categories = Category::all();
        $attributes = Attribute::all();
        return view('jobs.add', compact('locations', 'languages', 'categories', 'attributes'));
    }

    public function store(JobRequest $request)
    {
        $response = $this->create($request);

        // If the response is successful (201 Created)
        if ($response->getStatusCode() === 201) {
            return redirect()->route('jobs.add')->with('success', 'Job added successfully!');
        }

        // If there are validation errors or other issues
        return redirect()->back()->withInput()->with('error', $response->getData()->message);
    }
}
