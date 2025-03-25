<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Job;
use App\Models\JobAttributeValue;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobAttributesValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (JobAttributeValue::count() > 0) return;

        $jobs = Job::all();
        $attributes = Attribute::all();

        foreach ($jobs as $job) {
            foreach ($attributes as $attribute) {
                $value = null;

                switch ($attribute->type) {
                    case 'number':
                        $value = match ($attribute->name) {
                            'years_experience' => rand(0, 15),
                            'contract_length' => rand(1, 24),
                            default => null
                        };
                        break;
                    case 'boolean':
                        $value = (bool) rand(0, 1);
                        break;
                    case 'select':
                        $options = json_decode($attribute->options, true);
                        $value = $options[array_rand($options)];
                        break;
                    case 'date':
                        $value = Carbon::now()->addMonths(rand(1, 6))->toDateString();
                        break;
                }

                if ($value !== null) {
                    JobAttributeValue::create([
                        'job_id' => $job->id,
                        'attribute_id' => $attribute->id,
                        'value' => $value
                    ]);
                }
            }
        }
    }
}
