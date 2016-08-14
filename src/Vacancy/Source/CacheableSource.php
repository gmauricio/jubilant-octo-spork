<?php

namespace Vacancy\Source;

use Vacancy\Cache\CacheProvider;
use Vacancy\Source;

class CacheableSource implements Source
{    
    private $source;

    private $cache;

    public function __construct(CacheProvider $cache, $source)
    {
        $this->cache = $cache;
        $this->source = $source;
    }

    public function getName()
    {
        return 'cache';
    }

    public function get($id)
    {
        $vacancy = $this->cache->get($id);

        if (!$vacancy) {
            $vacancy = $this->source->get($id);
            $this->cache->set($id, $vacancy);
        }
        
        return $vacancy;
    }

    public function getAll()
    {
        $vacancies = $this->source->getAll();
        foreach($vacancies as $vacancy) {
            $this->cache->set($vacancy->id, $vacancy);
        }

        return $vacancies;
    }

    public function find(array $filters)
    {
        $vacancies = $this->source->find($filters);
        foreach($vacancies as $vacancy) {
            $this->cache->set($vacancy->id, $vacancy);
        }

        return $vacancies;
    }
}