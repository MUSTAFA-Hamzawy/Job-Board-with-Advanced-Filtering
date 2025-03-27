<?php

namespace App\Services\JobFilter;

use App\Services\JobFilter\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class EAVFilter implements FilterInterface
{
    private string $EAVPrefix = 'attribute:';

    public function applyFilter(Builder $query, array $conditionTokens): void
    {
        [$field, $operator, $value] = $conditionTokens;
        $attributeName = str_replace($this->EAVPrefix, '', $field);
        $sanitizedValue = trim($value, '"');

        if (strtoupper($operator) === 'LIKE') $sanitizedValue = "%{$sanitizedValue}%";

        $query->whereHas('jobAttributes', function ($q) use ($attributeName, $operator, $sanitizedValue) {
            $q->whereHas('attribute', fn($subQuery) => $subQuery->where('name', $attributeName))
                ->where('value', $operator, $sanitizedValue);
        });

    }
}
