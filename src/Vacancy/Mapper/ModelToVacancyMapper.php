<?php

namespace Vacancy\Mapper;

use Vacancy\Model\Vacancy;
use Vacancy\Mapper;
use Vacancy\Source\Model;

class ModelToVacancyMapper extends Mapper
{
    public function map($model) {
        $vacancy = new Vacancy();
        $vacancy->id = $model['id'];
        $vacancy->title = $model['title'];
        $vacancy->content = $model['content'];

        return $vacancy;
    }
}