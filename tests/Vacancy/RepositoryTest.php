<?php

namespace Vacancy\Test;

use PHPUnit\Framework\TestCase;
use Vacancy\Repository;
use Vacancy\Model\Vacancy;
use Vacancy\Source\MemorySource;

class RepositoryTest extends TestCase
{
    public function testThatRepositoryGetWithoutSourcesThrowsException()
    {
        $repository = new Repository();

        $this->expectException(\RuntimeException::class);
        $repository->get(1);
    }

    public function testThatRepositoryGetAllWithoutSourcesThrowsException()
    {
        $repository = new Repository();

        $this->expectException(\RuntimeException::class);
        $repository->getAll();
    }

    public function testRepositoryGetWithOneSourceAndNoVacancy()
    {
        $repository = new Repository();
        $source = new MemorySource([]);
        $repository->registerSource($source);
        
        $this->assertNull($repository->get(1));
    }

    public function testRepositoryGetAllWithOneSourceAndNoVacancies()
    {
        $repository = new Repository();
        $source = new MemorySource([]);
        $repository->registerSource($source);
        
        $this->assertEquals([], $repository->getAll(1));
    }

    public function testThatRepositoryGetAllWithVacancies()
    {
        $repository = new Repository();
        $vacancy = new Vacancy();
        $vacancy->id = 1;
        $source = new MemorySource([$vacancy]);
        $repository->registerSource($source);
        
        $this->assertEquals([$vacancy], $repository->getAll(1));
    }

    public function testThatRepositoryGetAllMergesResultsFromDifferentSources()
    {
        $repository = new Repository();
        
        $vacancy = new Vacancy();
        $vacancy->id = 1;
        $vacancy2 = new Vacancy();
        $vacancy2->id = 2;
        
        $source = new MemorySource([$vacancy]);
        $source2 = new MemorySource([$vacancy2], 'memory2');
        
        $repository->registerSource($source);
        $repository->registerSource($source2);
        
        $this->assertEquals([$vacancy, $vacancy2], $repository->getAll());
    }

    public function testThatRepositoryGetAllGetsOnlyFromSelectedSources()
    {
        $repository = new Repository();
        
        $vacancy = new Vacancy();
        $vacancy->id = 1;
        $vacancy2 = new Vacancy();
        $vacancy2->id = 2;
        
        $source = new MemorySource([$vacancy]);
        $source2 = new MemorySource([$vacancy2], 'memory2');
        
        $repository->registerSource($source);
        $repository->registerSource($source2);
        
        $this->assertEquals([$vacancy], $repository->using('memory')->getAll());
        $this->assertEquals([$vacancy2], $repository->using('memory2')->getAll());
    }
}
?>