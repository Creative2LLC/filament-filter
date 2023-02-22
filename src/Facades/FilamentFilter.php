<?php

namespace Creative2LLC\FilamentFilter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Creative2LLC\FilamentFilter\FilamentFilter
 */
class FilamentFilter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Creative2LLC\FilamentFilter\FilamentFilter::class;
    }
}
