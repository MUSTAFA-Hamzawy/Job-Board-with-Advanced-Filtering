<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'company_name',
        'min_salary',
        'max_salary',
        'is_remote',
        'job_type',
        'status',
        'published_at',
    ];

    protected $table = 'jobs';

    public function languages(){
        return $this->belongsToMany(Language::class, 'jobs_languages', 'job_id', 'language_id')->withTimestamps();
    }
    public function locations(){
        return $this->belongsToMany(Language::class, 'jobs_locations', 'job_id', 'location_id')->withTimestamps();
    }
    public function categories(){
        return $this->belongsToMany(Language::class, 'jobs_categories', 'job_id', 'category_id')->withTimestamps();
    }
    public function attributes()
    {
        return $this->hasMany(JobAttributeValue::class, 'attribute_id');
    }
}
