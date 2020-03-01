<?php

namespace Sabatino\EasyWebpackBuild;

class Facade extends \Illuminate\Support\Facades\Facade
{

    protected static function getFacadeAccessor()
    {
        return EasyWebpackBuild::class;
    }
}
