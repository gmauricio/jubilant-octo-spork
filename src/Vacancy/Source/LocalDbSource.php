<?php

namespace Vacancy\Source;

use Vacancy\Source;
use Vacancy\Mapper;

class LocalDbSource implements SearchableSource
{
    private $name;
    
    private $connection;

    private $mapper;
    

    public function __construct($name, $connection, Mapper $mapper)
    {
        $this->name = $name;
        $this->connection = $connection;
        $this->mapper = $mapper;
    }

    public function getName()
    {
        return $this->name;
    }

    public function get($id)
    {
        $result = $this->connection->query('vacancies')->where(['id' => $id])->first();
        
        return $this->mapper->map($result);
    }

    public function getAll()
    {
        $result = $this->connection->query('vacancies')->all();
        
        return $this->mapper->map($result);
    }

    public function find(array $filters)
    {
        $result = $this->connection->query('vacancies')->where($filters)->all();
        
        return $this->mapper->map($result);
    }
}