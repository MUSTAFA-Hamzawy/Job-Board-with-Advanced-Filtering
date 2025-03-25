<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAttributeValue extends Model
{
    use HasFactory;
    protected $fillable = ['job_id', 'attribute_id', 'value'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
