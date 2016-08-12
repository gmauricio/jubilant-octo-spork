<?php

namespace Vacancy\Source;

use Vacancy\Source;

class MemorySource implements Source
{
    private $vacancies = [];
    private $name;

    public function __construct(array $vacancies, $name = 'memory')
    {
        $this->name = $name;
        $this->vacancies = $vacancies;
    }

    public function getName()
    {
        return $this->name;
    }

    public function get($id)
    {
        $results = array_filter($this->vacancies, function($vacancy) {
            return $vacancy->id === $id; 
        });
        if (count($results) > 0) {
            return $results[0];
        }

        return null;
    }

    public function getAll()
    {
        return $this->vacancies;
    }

    public function filter(array $filters)
    {
        return $this->vacancies;
    }
}