<?php

namespace OhMyCod3\PeopleManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OhMyCod3\PeopleManager\Skeleton\SkeletonClass
 */
class PeopleManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'people-manager';
    }
}
