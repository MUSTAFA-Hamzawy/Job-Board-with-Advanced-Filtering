<?php

namespace App\Services\JobFilter;
use Illuminate\Database\Eloquent\Builder;
interface FilterInterface
{
    public function applyFilter(Builder $query, array $conditionTokens): void;
}
