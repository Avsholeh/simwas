<?php

if (!function_exists('dq')) {
    function dq($builder)
    {
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        $query =  vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
        return dd($query);
    }
}
