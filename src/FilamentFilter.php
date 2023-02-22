<?php

namespace Creative2LLC\FilamentFilter;

class FilamentFilter
{
    public static function applyQuery($query, $conditionals)
    {
        foreach ($conditionals as $index => $conditional) {
            $subQuery = [];

            foreach ($conditional['data']['and_condition'] as $key => $q) {
                $subQuery[] = [$q['column'], $q['operator'], $q['value']];
            }

            if ($conditional['type'] == 'and') {
                $query->where($subQuery);
            } else {
                $query->orWhere($subQuery);
            }
        }

        return $query;
    }
}
