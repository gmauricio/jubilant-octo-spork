<?php

namespace Vacancy\Test\Mapper;

use PHPUnit\Framework\TestCase;
use Vacancy\Model\Vacancy;
use Vacancy\Source\Model;
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

    /**
     * @dataProvider singleMapsProvider
     */
    public function testThatReverseMapMapReturnsSameObject($mapper, $vacancy, $data) {
        $this->assertEquals($data, $mapper->reverseMap($mapper->map($data)));
    }

    /**
     * @dataProvider singleMapsProvider
     */
    public function testThatMapReverseMapReturnsSameObject($mapper, $vacancy, $data) {
        $this->assertEquals($vacancy, $mapper->map($mapper->reverseMap($vacancy)));
    }

    public function singleMapsProvider()
    {
        return  [
            [
                new ApiMapper(), 
                new Model(['id' => 1, 'title' => 'the title']),
                ['id' => 1, 'title' => 'the title']
            ],
            [
                new LocalDbMapper(), 
                new Model(['id' => 2, 'title' => 'another title']),
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
                    new Model(['id' => 1, 'title' => 'the title']), 
                    new Model(['id' => 2, 'title' => 'this is a vacancy'])
                ], 
                [
                    ['id' => 1, 'title' => 'the title'],
                    ['id' => 2, 'title' => 'this is a vacancy']
                ]
            ],
            [
                new LocalDbMapper(), 
                [
                    new Model(['id' => 3, 'title' => 'one more title']), 
                    new Model(['id' => 4, 'title' => 'I vacancy'])
                ],
                [
                    ['id' => 3, 'title' => 'one more title'],
                    ['id' => 4, 'title' => 'I vacancy'],
                ]
                
            ],
        ];
    }
}