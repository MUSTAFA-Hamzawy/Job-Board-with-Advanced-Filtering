<?php

namespace App\Services\JobFilter;

use App\Services\JobFilter\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class BasicFilter implements FilterInterface
{
    public function applyFilter(Builder $query, array $conditionTokens): void
    {
        [$field, $operator, $value] = $conditionTokens;
        $value = trim($value, '"');

        switch (true) {
            case $field === 'description':  // special case for using ts_vector for speed Text-Search
                $searchColumn = 'description_search_vector';
                $tsQueryValue = implode(' & ', explode(' ', $value));
                $query->whereRaw("$searchColumn @@ to_tsquery('english', ?)", [$tsQueryValue]);
                break;

            case strtoupper($operator) === 'LIKE':
                $query->where($field, $operator, "%{$value}%");
                break;

            default:
                $query->where($field, $operator, $value);
        }
    }
}
