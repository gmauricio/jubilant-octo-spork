<?php

namespace Vacancy\Test\Source;

use PHPUnit\Framework\TestCase;
use Vacancy\Model\Vacancy;
use Vacancy\Cache\CacheProvider;
use Vacancy\Source;
use Vacancy\Source\SearchableSource;
use Vacancy\Source\CacheableSource;
use Vacancy\Source\MemorySource;

class CacheableSourceTest extends TestCase
{    
    public function testThatSourceIsCalledIfVacancyNotCached()
    {
        $vacancy = new Vacancy();
        $vacancy->id = 1;

        $cache = $this->createMock(CacheProvider::class);
        $cache->expects($this->once())->method('get')->willReturn(null);

        $source = $this->createMock(SearchableSource::class);
        $source->expects($this->once())->method('get')->willReturn($vacancy);

        $cacheableSource = new CacheableSource($cache, $source);

        $this->assertEquals($vacancy, $cacheableSource->get(1));
    }

    public function testThatSourceIsNotCalledIfVacancyIsCached()
    {
        $vacancy = new Vacancy();
        $vacancy->id = 1;

        $cache = $this->createMock(CacheProvider::class);
        $cache->expects($this->once())->method('get')->willReturn($vacancy);

        $source = $this->createMock(SearchableSource::class);
        $source->expects($this->never())->method('get');

        $cacheableSource = new CacheableSource($cache, $source);

        $this->assertEquals($vacancy, $cacheableSource->get(1));
    }
}