<?php

namespace Vacancy;


interface Source
{
    public function getName();

    public function get($id);

    public function getAll();

    public function find(array $filters);
}