<?php

namespace App\Services\JobFilter;

use App\Models\Job;

class FilterFactory
{
    private static string $EAVPrefix = 'attribute:';
    private static ?array $supportedRelationships = null;

    public static function create(array $conditionTokens): FilterInterface
    {
        $field = $conditionTokens[0];
        if (self::$supportedRelationships === null) self::$supportedRelationships = Job::getRelationships();

        if (in_array($field, self::$supportedRelationships, true)) return new RelationshipFilter();
        if (str_starts_with($field, self::$EAVPrefix)) return new EAVFilter();

        return new BasicFilter();
    }

}
