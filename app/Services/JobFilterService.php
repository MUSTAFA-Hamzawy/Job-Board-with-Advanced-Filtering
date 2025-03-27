<?php

namespace App\Services;

use App\Models\Job;
use App\Services\JobFilter\FilterFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobFilterService
{
    public function applyFilters(Request $request): Builder
    {
        $query = Job::query()->with([
            'languages:name',
            'locations:city,state,country',
            'categories:name',
            'jobAttributes:job_id,attribute_id,value',
            'jobAttributes.attribute:id,name'
        ]);

        if ($request->has('filter')) {
            $filterString = $request->get('filter');
            $parsedFilters = $this->splitFilterGroups($filterString);
            $this->buildQuery($query, $parsedFilters);
        }
        return $query;
    }

    private function splitFilterGroups(string $filterString): array
    {
        $groups = [];
        $operators = [];
        $currentGroup = '';
        $depth = 0;

        /* This regex tokenizes the filter string by matching:
            * Parentheses ( and ) to handle nested expressions.
            * Quoted strings "" to handle multi-word text.
            * Logical operators AND\OR as separate tokens.
            * Any non-whitespace sequence (`[^\s()]+`) to capture filter conditions like `job_type=Full-time`.
            * It is used to split the filter into smaller groups.
        */
        preg_match_all('/\(|\)|"[^"]*"|AND|OR|[^\s()]+/', $filterString, $tokens);
        $tokens = $tokens[0];

        foreach ($tokens as $token) {
            switch ($token) {
                case '(':
                    if ($depth > 0) $currentGroup .= ' (';
                    $depth++;
                    break;

                case ')':
                    $depth--;
                    if ($depth > 0) $currentGroup .= ') ';
                    else {
                        if (trim($currentGroup) !== '') $groups[] = trim($currentGroup);
                        $currentGroup = '';
                    }
                    break;

                case 'AND':
                case 'OR':
                    if ($depth === 0) {
                        if (trim($currentGroup) !== '') $groups[] = trim($currentGroup);
                        $operators[] = $token;
                        $currentGroup = '';
                    } else $currentGroup .= ' ' . $token;
                    break;

                default:
                    $currentGroup .= ($currentGroup === '' ? '' : ' ') . $token;
                    break;
            }
        }

        if (!empty(trim($currentGroup))) {
            $groups[] = trim($currentGroup);
        }

        // removing any empty groups
        $groups = array_filter($groups, fn($group) => !empty($group));
        return ['groups' => array_values($groups), 'operators' => $operators];
    }

    private function buildQuery(Builder $query, array $parsedFilters): void
    {
        $groups = $parsedFilters['groups'];
        $operators = $parsedFilters['operators'];

        $query->where(function ($q) use ($groups, $operators) {
            foreach ($groups as $i => $group) {
                if ($i === 0) {
                    $this->parseGroup($q, $group);
                } else {
                    $operator = $operators[$i-1];
                    if ($operator === 'AND'){
                        $q->where(function ($subQuery) use ($group) {
                            $this->parseGroup($subQuery, $group);
                        });
                    }else{
                        $q->orWhere(function ($subQuery) use ($group) {
                            $this->parseGroup($subQuery, $group);
                        });
                    }

                }
            }
        });
    }

    private function parseGroup(Builder $query, string $group): void
    {
        // Tokenizes a filter string into fields, operators, and values while preserving logical operators (AND/OR).
        preg_match_all('/(?:[^\s"\[\]()=<>!]+|"(?:[^"\\\\]|\\\\.)*")|[=<>!]+|\[[^\]]*\]|\(|\)|AND|OR|[^\s()]+/', $group, $tokens);

        // if the token is parentheses '(' ')', discard it
        $tokens = array_filter($tokens[0], function ($token) { return $token !== '(' && $token !== ')';});

        $currentCondition = [];
        foreach ($tokens as $token) {
            if ($token === 'AND' || $token === 'OR') {
                if (!empty($currentCondition)) {
                    $this->applyCondition($query, $currentCondition);
                }
                $currentCondition = [];
            } else {
                $currentCondition[] = $token;
            }
        }

        if (!empty($currentCondition)) {
            $this->applyCondition($query, $currentCondition);
        }
    }

    private function applyCondition(Builder $query, array $conditionTokens): void
    {
        if (empty($conditionTokens)) return;
        $filter = FilterFactory::create($conditionTokens);
        $filter->applyFilter($query, $conditionTokens);
    }
}
