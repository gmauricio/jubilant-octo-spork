<?php

namespace Vacancy\Test\Mapper;

use PHPUnit\Framework\TestCase;
use Vacancy\Model\Vacancy;
use Vacancy\Mapper\ApiMapper;
use Vacancy\Mapper\LocalDbMapper;

class MapperTest extends TestCase
{    
    /**
     * @dataProvider singleMapsProvider
     */
    public function testThatSingleObjectIsMapped($mapper, $vacancy, $data)
    {
        $this->assertEquals($vacancy, $mapper->map($data));
    }

    public function singleMapsProvider()
    {
        return  [
            [
                new ApiMapper(), 
                $this->createVacancy(1, 'the title'),
                ['id' => 1, 'title' => 'the title']
            ],
            [
                new LocalDbMapper(), 
                $this->createVacancy(2, 'another title'),
                ['id' => 2, 'title' => 'another title']
            ],
        ];
    }

    /**
     * @dataProvider collectionMapsProvider
     */
    public function testThatCollectionIsMapped($mapper, $vacancies, $data)
    {
        $this->assertEquals($vacancies, $mapper->mapCollection($data));
    }

    public function collectionMapsProvider()
    {
        return  [
            [
                new ApiMapper(), 
                [
                    $this->createVacancy(1, 'the title'), 
                    $this->createVacancy(2, 'this is a vacancy')
                ], 
                [
                    ['id' => 1, 'title' => 'the title'],
                    ['id' => 2, 'title' => 'this is a vacancy']
                ]
            ],
            [
                new LocalDbMapper(), 
                [
                    $this->createVacancy(3, 'one more title'), 
                    $this->createVacancy(4, 'I vacancy')
                ],
                [
                    ['id' => 3, 'title' => 'one more title'],
                    ['id' => 4, 'title' => 'I vacancy'],
                ]
                
            ],
        ];
    }

    private function createVacancy($id, $title) {
        $vacancy = new Vacancy();
        $vacancy->id = $id;
        $vacancy->title = $title;
        
        return $vacancy;
    }
}