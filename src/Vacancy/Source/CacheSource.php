<?php

namespace Vacancy\Source;

use Vacancy\Cache\CacheProvider;
use Vacancy\Source;

class CacheSource implements Source
{    
    private $source;

    public function __construct(CacheProvider $cacheProvider, $source)
    {
        $this->source = $source;
    }

    public function get($id)
    {
        $vacancy = $cacheProvider->get($id);

        if (!$vacancy) {
            $vacancy = $source->get($id);
            $cacheProvider->set($id, $vacancy);
        }
        
        return $vacancy;
    }

    public function getAll()
    {
        $vacancies = $this->source->getAll();
        foreach($vacancies as $vacancy) {
            $cacheProvider->set($vacancy->id, $vacancy);
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