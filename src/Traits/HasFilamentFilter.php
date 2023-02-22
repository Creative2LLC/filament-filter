<?php

namespace Creative2LLC\FilamentFilter\Traits;

use Creative2LLC\FilamentFilter\FilamentFilter;
use Illuminate\Database\Eloquent\Builder;

/**
 * HasFilamentFilter
 */
trait HasFilamentFilter
{
    public $customQuery;

    public function getListeners()
    {
        return ['query' => 'query'];
    }

    public function query($queryString)
    {
        $this->customQuery = $queryString;
        $this->updatedTableSearchQuery();
    }

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        if (! empty($this->customQuery)) {
            return FilamentFilter::applyQuery($query, $this->customQuery);
        }

        return $query;
    }
}
