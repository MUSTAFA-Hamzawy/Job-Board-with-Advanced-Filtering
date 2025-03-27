<?php

namespace App\Services;

use App\Models\Job;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JobFilterService
{
    public function applyFilters(Request $request): Builder
    {
        $query = Job::query()->with(['languages', 'locations', 'categories', 'jobAttributes.attribute']);;

        if ($request->has('filter')) {
            $filterString = $request->get('filter');
            $parsedFilters = $this->splitFilterGroups($filterString);
//dd($parsedFilters);
            $this->buildQuery($query, $parsedFilters);
        }
//        dd($query->toRawSql());
        return $query;
    }

    private function splitFilterGroups(string $filterString)
    {
        $groups = [];
        $operators = [];
        $stack = [];
        $currentGroup = '';
        $depth = 0;

        // Tokenize while preserving spaces inside quotes and handling nested parentheses
        preg_match_all('/\(|\)|"[^"]*"|AND|OR|[^\s()]+/', $filterString, $tokens);
        $tokens = $tokens[0];
//dd($tokens);
        foreach ($tokens as $token) {
            if ($token === '(') {
                if ($depth > 0) {
                    $currentGroup .= ' (';  // Preserve opening parenthesis inside a group
                }
                $depth++;
            } elseif ($token === ')') {
                $depth--;
                if ($depth > 0) {
                    $currentGroup .= ') ';  // Preserve closing parenthesis inside a group
                } else {
                    if (trim($currentGroup) !== '') {
                        $groups[] = trim($currentGroup);
                    }
                    $currentGroup = '';
                }
            } elseif ($token === 'AND' || $token === 'OR') {
                if ($depth === 0) {
                    if (trim($currentGroup) !== '') {
                        $groups[] = trim($currentGroup);
                    }
                    $operators[] = $token;
                    $currentGroup = '';
                } else {
                    $currentGroup .= ' ' . $token;  // Inside a group, keep it as part of the expression
                }
            } else {
                $currentGroup .= ($currentGroup === '' ? '' : ' ') . $token;
            }
        }

        if (!empty(trim($currentGroup))) {
            $groups[] = trim($currentGroup);
        }

        // Remove any empty groups
        $groups = array_filter($groups, fn($group) => !empty($group));

        return ['groups' => array_values($groups), 'operators' => $operators];
    }

    private function buildQuery(Builder $query, array $parsedFilters)
    {
//        dd($parsedFilters);
        $groups = $parsedFilters['groups'];
        $operators = $parsedFilters['operators'];
//        dd($groups);
        $query->where(function ($q) use ($groups, $operators) {
            foreach ($groups as $index => $group) {
                if ($index === 0) {
                    $this->parseGroup($q, $group);
                } else {
                    $operator = $operators[$index - 1]; // Get corresponding AND/OR
//                    dd($operator, $group);

                    $q->{$operator === 'AND' ? 'where' : 'orWhere'}(function ($subQuery) use ($group) {

                        $this->parseGroup($subQuery, $group);
                    });
                }
            }
        });
    }

    private function parseGroup(Builder $query, string $group)
    {
        preg_match_all('/(?:[^\s"\[\]()=<>!]+|"(?:[^"\\\\]|\\\\.)*")|[=<>!]+|\[[^\]]*\]|\(|\)|AND|OR|[^\s()]+/', $group, $tokens);

        $tokens = array_filter($tokens[0], function ($token) {
            return $token !== '(' && $token !== ')'; // Remove parentheses
        });

//        if ($group == "attribute:years_experience>=3")
//        {
//                    dd($group, $tokens); // Debugging output
//        }

//        dd($group, $tokens); // Debugging output

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

    private function applyCondition0(Builder $query, array $conditionTokens)
    {
        // Ensure we have a valid condition
        if (empty($conditionTokens)) {
            return;
        }
        if ($conditionTokens[0] === 'min_salary') {
            dd($conditionTokens);
        }
//dd($conditionTokens);

        // Handle cases where the condition is in the format field="value"
        if ($conditionTokens[0] === 'min_salary') {
            dd('hi');
        }
        if (preg_match('/^([^=<>!]+)([=<>!]+)"?(.*?)"?$/', $conditionTokens[0], $matches)) {
            if ($conditionTokens[0] === 'min_salary') {
                dd('hi');
            }
            [, $field, $operator, $value] = $matches;
            $value = trim($value, '"'); // Remove any surrounding quotes

            // Check if it's an EAV attribute filter
            if (strpos($field, 'attribute:') === 0) {
                $field = str_replace('attribute:', '', $field);
                $this->applyEAVFilter($query, $field, $operator, $value);
            } else {
                // Apply normal condition
                $query->where($field, $operator, $value);
//                dd($query->toRawSql());
                if ($conditionTokens[0] === 'min_salary') {
                    dd('hi');
                    dd($query->toRawSql());
                }
            }
        } elseif (count($conditionTokens) === 3 && in_array(strtoupper($conditionTokens[1]), ['HAS_ANY', 'IS_ANY'])) {
            if ($conditionTokens[0] === 'languages') {
                $this->applyLanguageFilter($query, $conditionTokens[2]);
            } elseif ($conditionTokens[0] === 'locations') {
                $this->applyLocationFilter($query, $conditionTokens[2]);
            }
        }
    }

    private function applyCondition(Builder $query, array $conditionTokens)
    {
//        if ($conditionTokens[1] == ">=")
//        {
//            dd($conditionTokens); // Debugging output
//        }
        // Ensure we have a valid condition
        if (empty($conditionTokens)) {
            return;
        }
//        dd($conditionTokens);
//        if ($conditionTokens[0] === 'attribute') {
//            dd($conditionTokens);
//        }

        // Handle special cases like HAS_ANY or IS_ANY
        [$field, $operator, $value] = $conditionTokens;
        if (count($conditionTokens) === 3 && in_array(strtoupper($conditionTokens[1]), ['HAS_ANY', 'IS_ANY'])) {
            if ($conditionTokens[0] === 'languages') {
                $this->applyLanguageFilter($query, $conditionTokens[2]);
            } elseif ($conditionTokens[0] === 'locations') {
                $this->applyLocationFilter($query, $conditionTokens[2]);
            } elseif ($conditionTokens[0] === 'categories') {
                $this->applyCategoryFilter($query, $conditionTokens[2]);
            }
        } else if (strpos($field, 'attribute:') === 0) {
            $field = str_replace('attribute:', '', $field);
            $this->applyEAVFilter($query, $field, $operator, $value);
        } // Handle simple expressions like "min_salary > 50000000"
        else if (count($conditionTokens) === 3) {
            [$field, $operator, $value] = $conditionTokens;

            // Remove any extra quotes from the value
            $value = trim($value, '"');

            // special case for job description: Use full-text search
            if ($field === 'description') {
                $searchColumn = 'description_search_vector';
                // Convert value into tsquery format (concatenated with &)
                $tsQueryValue = implode(' & ', explode(' ', $value));
                $query->whereRaw("$searchColumn @@ to_tsquery('english', ?)", [$tsQueryValue]);
                return;
            }

            // If the operator is LIKE, wrap the value with % for wildcard searching
            if (strtoupper($operator) === 'LIKE') {
                $value = "%{$value}%";
            }

            // Apply the filter normally
            $query->where($field, $operator, $value);

        }


    }


    private function applyLanguageFilter(Builder $query, string $values)
    {
        // Remove square brackets and trim spaces
        $values = trim($values, '[]');

        // Properly split by commas while trimming each value
        $valuesArray = array_map('trim', explode(',', $values));

        // Remove any empty values due to malformed input
        $valuesArray = array_filter($valuesArray, fn($val) => !empty($val));

        // Apply filter
        $query->whereHas('languages', function ($q) use ($valuesArray) {
            $q->whereIn('name', $valuesArray);
        });

    }

    private function applyLocationFilter(Builder $query, string $values)
    {
        $valuesArray = array_unique(explode(',', trim($values, '[]'))); // Remove duplicates
        $valuesArray = array_map(fn($val) => trim($val, '"'), $valuesArray);

        $query->whereHas('locations', function ($q) use ($valuesArray) {
            $q->where(function ($subQuery) use ($valuesArray) {
                foreach ($valuesArray as $value) {
                    $subQuery->orWhere('city', $value)
                        ->orWhere('state', $value)
                        ->orWhere('country', $value);
                }
            });
        });

    }

    private function applyCategoryFilter(Builder $query, string $categories)
    {
        // Convert string to array (e.g., '["Software Development","Data Science"]' → ['Software Development', 'Data Science'])
        $categoryList = json_decode($categories, true);

        if (is_array($categoryList) && count($categoryList) > 0) {
            // Assuming 'category_id' is stored in jobs table and categories table has 'name' column
            $query->whereHas('categories', function ($q) use ($categoryList) {
                $q->whereIn('name', $categoryList);
            });
        }
    }

    private function applyRelationshipFilter(Builder $query, string $relation, string $operator, string $values)
    {

        $valuesArray = array_unique(explode(',', trim($values, '[]'))); // Remove duplicates

        // Trim each value to remove any spaces
        $valuesArray = array_map('trim', $valuesArray);
        $valuesArray = array_map(fn($val) => trim($val, '"'), $valuesArray);

        // Apply the filtering logic
        $query->whereHas($relation, function ($q) use ($valuesArray) {
            $q->whereIn('name', $valuesArray);
        });

    }

    private function applyEAVFilter(Builder $query, string $attributeName, string $operator, string $value)
    {
        $sanitizedValue = str_replace('"', '', $value);
        if (strtoupper($operator) === 'LIKE') {
            $sanitizedValue = "%{$value}%";
        }

        $query->whereHas('jobAttributes', function ($q) use ($attributeName, $operator, $sanitizedValue) {
            $q->whereHas('attribute', function ($subQuery) use ($attributeName) {
                $subQuery->where('name', $attributeName);
            })->where('value', $operator, $sanitizedValue);
        });
//        dd( $query->toRawSql());
    }
}
