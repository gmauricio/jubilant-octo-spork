<?php

namespace Vacancy;

use Vacancy\Source;
use Vacancy\Source\SearchableSource;
use Vacancy\Mapper;

class Repository
{    
    /**
     * @var Vacancy\Source\Source[]
     */
    private $sources;

    private $mapper;

    /**
     * @param Vacancy\Source\Source[] sources
     */
    public function __construct(array $sources, Mapper $mapper)
    {
        $this->sources = array_reduce($sources, function ($result, $source) {
            $result[$source->getName()] = $source;
            return $result;
        }, []);
        $this->mapper = $mapper;
    }

    public function get($id)
    {
        if (count($this->sources) === 0) {
            throw new \RuntimeException('No source registered.');
        }
        foreach($this->sources as $source) {
            if ($vacancy = $source->get($id)) {
                return $this->mapper->map($vacancy);
            }
        }

        return null;
    }

    public function getAll()
    {
        if (count($this->sources) === 0) {
            throw new \RuntimeException('No source registered.');
        }
        $vacancies = [];
        foreach($this->sources as $source) {
            $vacancies = array_merge($vacancies, $source->getAll());
        }

        return $this->mapper->mapCollection($vacancies);
    }

    public function find(array $filters)
    {
        if (count($this->sources) === 0) {
            throw new \RuntimeException('No source registered.');
        }
        $vacancies = [];
        foreach($this->sources as $source) {
            if ($source instanceof SearchableSource) {
                $vacancies = array_merge($vacancies, $source->find($filters));
            }
        }

        return $this->mapper->mapCollection($vacancies);
    }

    public function addSource(Source $source)
    {
        $this->sources[$source->getName()] = $source;
        
        return $this;
    }

    public function removeSource($key) 
    {
        return new Repository(array_filter($this->sources, function($name, $source) {
            return $name != $key;
        }, ARRAY_FILTER_USE_BOTH));
    }
    
    public function using($key)
    {
        $keys = is_array($key) ? $key : [$key];
        return new Repository(array_map(function($key) {
            if (!isset($this->sources[$key])) {
                throw new \RuntimeException('Source with key ' . $key . ' is not registered');
            }
            return $this->sources[$key];
        }, $keys), $this->mapper);

        return $this;
    }
}