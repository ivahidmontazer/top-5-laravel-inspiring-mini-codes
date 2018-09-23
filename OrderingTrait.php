<?php

namespace App\Scopes;

trait OrderingTrait
{
    public static function bootOrderingTrait()
    {
        static::addGlobalScope(new OrderingScope(isset(static::$order) ? static::$order : 'created_at',
            isset(static::$direction) ? static::$direction : 'asc'));
    }

    public static function unOrder()
    {
        return (new static)->newQueryWithoutScope(new OrderingScope());
    }
}