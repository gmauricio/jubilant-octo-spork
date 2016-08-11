<?php

namespace Vacancy;

class Repository 
{    
    private $sources = [];

    private $selectedSources = [];

    public function get($id)
    {
        foreach($this->getSelectedSources() as $source) {
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
        foreach($this->getSelectedSources() as $source) {
            $vacancies = array_merge($vacancies, $source->getAll());
        }

        return $vacancies;
    }

    public function registerSource(Source $source)
    {
        $this->sources[$source->getName()] = $source;
        
        return $this;
    }
    
    public function using($key)
    {
        $keys = is_array($key) ? $key : [$key];
        $this->selectedSources = array_map(function($key) {
            if (!isset($this->sources[$key])) {
                throw new \RuntimeException('Source with key ' . $key . 'is not registered');
            }
            return $this->sources[$key];
        }, $keys);

        return $this;
    }

    private function getSelectedSources()
    {
        if (count($this->sources) === 0) {
            throw new \RuntimeException('No source registered.');
        }
        
        if (count($this->selectedSources) > 0) {
            return $this->selectedSources;
        }

        return $this->sources;
    } 
}