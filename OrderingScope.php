<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderingScope implements Scope
{

    protected $orderBy;

    protected $direction;

    public function __construct($orderBy = 'created_at', $direction = 'asc')
    {
        $this->orderBy = $orderBy;
        $this->direction = $direction;
    }

    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy($model->getTable() . '.' . $this->orderBy, $this->direction);
    }

    /**
     * @param Builder $builder
     * @param Model $model
     */
    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();
        $query->orders = [];
    }

}