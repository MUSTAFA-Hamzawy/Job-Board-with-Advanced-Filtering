<?php

namespace App\Services\JobFilter;

use App\Services\JobFilter\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class RelationshipFilter implements FilterInterface
{

    public function applyFilter(Builder $query, array $conditionTokens): void
    {
        [$field, $operator, $values] = $conditionTokens;
        $valuesArray = array_map('trim', explode(',', trim($values, '[]')));

        $operator = strtoupper($operator);
        $field = strtolower($field);

        if (!in_array($operator, ['HAS_ANY', 'IS_ANY'])) return; // ensure operator is valid

        if ($field === 'languages' || $field === 'categories') {
            $query->whereHas($field, fn($q) => $q->whereIn('name', $valuesArray));
        } elseif ($field === 'locations') {
            $query->whereHas($field, function ($q) use ($valuesArray) {
                $q->where(function ($subQuery) use ($valuesArray) {
                    foreach ($valuesArray as $value) {
                        $subQuery->orWhere('city', $value)
                            ->orWhere('state', $value)
                            ->orWhere('country', $value);
                    }
                });
            });
        }
    }

}
