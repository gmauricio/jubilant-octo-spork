<?php

namespace Vacancy\Cache;

class MemoryCache implements CacheProvider 
{    
    private $cache = [];

    public function get($key) {
        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        }
        return null;
    }

    public function set($key, $value) {
        $this->cache[$key] = $cache;
    }
}