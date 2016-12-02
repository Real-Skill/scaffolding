<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateEmployeeTest
 * @package AppBundle\Tests\Feature
 */
class UpdateEmployeeTest extends CreateEmployeeTest
{
    /**
     * @test
     */
    public function shouldSaveEmployeeIfProperDataIsGivenAndReturnItsId()
    {
        $expectedData = [
            'success' => true,
            'id' => 1,
        ];
        $data = [
            'name' => str_repeat('a', 64),
            'surname' => str_repeat('a', 64),
            'email' => str_repeat('a', 246).'@test.pl', //length: 254
            'bio' => str_repeat('a', 400),
            'daysInOffice' => 5,
        ];
        $response = $this->sendData($data);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());

        $this->client->request('GET', '/api/employee');

        $data['id'] = 1;
        $expectedData = [
            $data,
            [
                'id' => 2,
                'name' => 'Kent',
                'surname' => 'Beck',
                'email' => 'kent.beck@fake.pl',
                'bio' => 'An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process.',
                'daysInOffice' => 5,
            ],
            [
                'id' => 3,
                'name' => 'Robert Cecil',
                'surname' => 'Martin',
                'email' => 'robert.martin@fake.pl',
                'bio' => 'An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code.',
                'daysInOffice' => 4,
            ],
        ];

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldNotRequireBio()
    {
        $expectedData = [
            'success' => true,
            'id' => 1,
        ];
        $data = [
            'name' => str_repeat('a', 64),
            'surname' => str_repeat('a', 64),
            'email' => str_repeat('a', 246).'@test.pl', //length: 254
            'bio' => '',
            'daysInOffice' => 5,
        ];
        $response = $this->sendData($data);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());

        $this->client->request('GET', '/api/employee');

        $data['id'] = 1;
        $expectedData = [
            $data,
            [
                'id' => 2,
                'name' => 'Kent',
                'surname' => 'Beck',
                'email' => 'kent.beck@fake.pl',
                'bio' => 'An American software engineer and the creator of extreme programming, a software development methodology which eschews rigid formal specification for a collaborative and iterative design process.',
                'daysInOffice' => 5,
            ],
            [
                'id' => 3,
                'name' => 'Robert Cecil',
                'surname' => 'Martin',
                'email' => 'robert.martin@fake.pl',
                'bio' => 'An American software engineer and author. He is a co-author of the Agile Manifesto. He now runs a consulting firm called Clean Code.',
                'daysInOffice' => 4,
            ],
        ];

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadEmployeeData()];
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return '/api/employee/1';
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'PUT';
    }
}
