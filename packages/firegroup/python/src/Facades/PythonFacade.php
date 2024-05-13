<?php

namespace Firegroup\Python\Facades;

use Illuminate\Support\Facades\Facade;

class PythonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'python';
    }
}
