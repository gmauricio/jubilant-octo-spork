<?php

namespace Vacancy;

class Repository 
{    
    private $sources;

    public function __construct(array $sources)
    {
        $this->sources = array_reduce($sources, function ($result, $source) {
            $result[$source->getName()] = $source;
            return $result;
        }, []);
    }

    public function get($id)
    {
        if (count($this->sources) === 0) {
            throw new \RuntimeException('No source registered.');
        }
        foreach($this->sources as $source) {
            if ($vacancy = $source->get($id)) {
                return $vacancy;
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

        return $vacancies;
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
        }, $keys));

        return $this;
    }
}