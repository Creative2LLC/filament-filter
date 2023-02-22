<?php

namespace Creative2LLC\FilamentFilter\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;

interface ImplementsFilamentFilter
{
    public function query($queryString);
    public function applySearchToTableQuery(Builder $query);
    public function getColumnsProperty(): array;
}
