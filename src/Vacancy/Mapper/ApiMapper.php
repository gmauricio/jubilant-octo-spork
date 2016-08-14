<?php

namespace Vacancy\Mapper;

use Vacancy\Model\Vacancy;
use Vacancy\Mapper;

class ApiMapper extends Mapper
{
    public function map($row) {
        $vacancy = new Vacancy();
        $vacancy->id = $row['id'];
        $vacancy->title = $row['title'];
        $vacancy->content = isset($row['content']) ? $row['content'] : null;

        return $vacancy;
    }
}