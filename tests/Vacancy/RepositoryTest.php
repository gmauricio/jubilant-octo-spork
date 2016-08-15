<?php

namespace Vacancy\Test;

use PHPUnit\Framework\TestCase;
use Vacancy\Repository;
use Vacancy\Model\Vacancy;
use Vacancy\Source\MemorySource;
use Vacancy\Source\Model;
use Vacancy\Mapper\ModelToVacancyMapper;

class RepositoryTest extends TestCase
{
    public function testThatRepositoryGetWithoutSourcesThrowsException()
    {
        $repository = new Repository([], new ModelToVacancyMapper());

        $this->expectException(\RuntimeException::class);
        $repository->get(1);
    }

    public function testThatRepositoryGetAllWithoutSourcesThrowsException()
    {
        $repository = new Repository([], new ModelToVacancyMapper());

        $this->expectException(\RuntimeException::class);
        $repository->getAll();
    }

    public function testRepositoryGetWithOneSourceAndNoVacancy()
    {
        $source = new MemorySource([]);
        $repository = new Repository([$source], new ModelToVacancyMapper());
        
        $this->assertNull($repository->get(1));
    }

    public function testRepositoryGetAllWithOneSourceAndNoVacancies()
    {
        $source = new MemorySource([]);
        $repository = new Repository([$source], new ModelToVacancyMapper());
        
        $this->assertEquals([], $repository->getAll(1));
    }

    public function testThatRepositoryGetAllWithVacancies()
    {
        $vacancy = new Vacancy();
        $vacancy->id = 1;
        $model = new Model(['id' => 1]);

        $source = new MemorySource([$model]);
        $repository = new Repository([$source], new ModelToVacancyMapper());
        
        $this->assertEquals([$vacancy], $repository->getAll(1));
    }

    public function testThatRepositoryGetAllMergesResultsFromDifferentSources()
    {
        $vacancy = new Vacancy();
        $vacancy->id = 1;
        $vacancy2 = new Vacancy();
        $vacancy2->id = 2;
        $model = new Model(['id' => 1]);
        $model2 = new Model(['id' => 2]);
        
        $source = new MemorySource([$model]);
        $source2 = new MemorySource([$model2], 'memory2');

        $repository = new Repository([$source, $source2], new ModelToVacancyMapper());
        
        $this->assertEquals([$vacancy, $vacancy2], $repository->getAll());
    }

    public function testThatRepositoryGetAllGetsOnlyFromSelectedSources()
    {
        $vacancy = new Vacancy();
        $vacancy->id = 1;
        $vacancy2 = new Vacancy();
        $vacancy2->id = 2;
        $model = new Model(['id' => 1]);
        $model2 = new Model(['id' => 2]);
        
        $source = new MemorySource([$model]);
        $source2 = new MemorySource([$model2], 'memory2');

        $repository = new Repository([$source, $source2], new ModelToVacancyMapper());
        
        $this->assertEquals([$vacancy], $repository->using('memory')->getAll());
        $this->assertEquals([$vacancy2], $repository->using('memory2')->getAll());
    }
}
?>