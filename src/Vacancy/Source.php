<?php

namespace Vacancy;


interface Source
{
    public function getName();

    public function get($id);

    public function getAll();

    public function filter(array $filters);
}