<?php

namespace Vacancy\Source;

use Vacancy\Source;
use Vacancy\Mapper;

class ApiSource implements Source
{
    private $name;
    
    private $httpClient;

    private $mapper;
    
    public function __construct($name, $httpClient, Mapper $mapper)
    {
        $this->name = $name;
        $this->httpClient = $httpClient;
        $this->mapper = $mapper;
    }

    public function getName()
    {
        return $this->name;
    }

    public function get($id)
    {
        $path = '/vacancies/' . $id;
        return $mapper->map($httpClient->get($path));
    }

    public function getAll()
    {
        $path = '/vacancies';
        return $mapper->mapCollection($httpClient->get($path));
    }

    public function find(array $filters)
    {
        $path = '/vacancies/search?' . http_build_query($filters);
        return $mapper->mapCollection($httpClient->get($path));
    }
}