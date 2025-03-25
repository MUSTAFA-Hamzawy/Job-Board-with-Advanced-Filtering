<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'options'];

    protected $casts = ['options' => 'array'];  // to cast the JSONB fetched from db into normal array in php

    public function values() {
        return $this->hasMany(JobAttributeValue::class, 'attribute_id');
    }
}
