<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class JobService
{
    public function createJob(array $data)
    {
        try {
            DB::beginTransaction();

            $job = Job::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'company_name' => $data['company_name'],
                'min_salary' => $data['min_salary'],
                'max_salary' => $data['max_salary'],
                'is_remote' => $data['is_remote'] ?? false, // default is false
                'job_type' => $data['job_type'],
                'status' => $data['status'],
                'published_at' => $data['published_at'] ?? now(),
            ]);

            $job->locations()->attach($data['location_ids']);
            $job->languages()->attach($data['language_ids']);
            $job->categories()->attach($data['category_id']);
            if (!empty($data['attributes'])) {
                foreach ($data['attributes'] as $attribute) {
                    DB::table('job_attribute_values')->insert([
                        'job_id' => $job->id,
                        'attribute_id' => $attribute['id'],
                        'value' => $attribute['value'],
                        'created_at' => now(),
                    ]);
                }
            }

            DB::commit();
            return $job;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }
}
