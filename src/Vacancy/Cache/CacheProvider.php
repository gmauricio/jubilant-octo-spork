<?php

namespace Vacancy\Cache;

interface CacheProvider 
{    
    public function get($key);

    public function set($key, $value);
}