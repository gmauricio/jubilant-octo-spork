<?php

namespace Vacancy;


abstract class Mapper
{
    public abstract function map($data);

    public abstract function reverseMap($data);

    public function mapCollection($collection) {
        return array_map(function($data) {
            return $this->map($data);
        }, $collection);
    }

    public function reverseMapCollection($collection) {
        return array_map(function($data) {
            return $this->reverseMap($data);
        }, $collection);
    }

    protected function removeNulls($array) {
        return array_filter($array, function($value) { return !is_null($value); });
    }
}