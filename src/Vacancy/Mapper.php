<?php

namespace Vacancy;


abstract class Mapper
{
    public abstract function map($data);

    public function mapCollection($collection) {
        return array_map(function($data) {
            return $this->map($data);
        }, $collection);
    }
}