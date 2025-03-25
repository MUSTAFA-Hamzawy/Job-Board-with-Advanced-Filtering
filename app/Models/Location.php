<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'country',
        'state',
        'city',
    ];

    public function jobs() {
        return $this->belongsToMany(Job::class, 'jobs_locations', 'location_id', 'job_id');
    }
}
