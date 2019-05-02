<?php

namespace Arcostasi\ConsoleLog\Facades;

use Illuminate\Support\Facades\Facade;

class Console extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'console';
    }
}