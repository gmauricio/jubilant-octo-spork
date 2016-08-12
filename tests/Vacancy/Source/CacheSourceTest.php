<?php

namespace Vacancy\Test\Source;

use PHPUnit\Framework\TestCase;
use Vacancy\Model\Vacancy;
use Vacancy\Cache\CacheProvider;
use Vacancy\Source;
use Vacancy\Source\CacheSource;
use Vacancy\Source\MemorySource;

class CacheSourceTest extends TestCase
{    
    public function testThatSourceIsCalledIfVacancyNotCached()
    {
        $vacancy = new Vacancy();
        $vacancy->id = 1;

        $cache = $this->createMock(CacheProvider::class);
        $cache->expects($this->once())->method('get')->willReturn(null);

        $source = $this->createMock(CacheProvider::class);
        $source->expects($this->once())->method('get')->willReturn($vacancy);

        $cacheSource = new CacheSource($cache, $source);

        $this->assertEquals($vacancy, $cacheSource->get(1));
    }

    public function testThatSourceIsNotCalledIfVacancyIsCached()
    {
        $vacancy = new Vacancy();
        $vacancy->id = 1;

        $cache = $this->createMock(CacheProvider::class);
        $cache->expects($this->once())->method('get')->willReturn($vacancy);

        $source = $this->createMock(CacheProvider::class);
        $source->expects($this->never())->method('get');

        $cacheSource = new CacheSource($cache, $source);

        $this->assertEquals($vacancy, $cacheSource->get(1));
    }
}