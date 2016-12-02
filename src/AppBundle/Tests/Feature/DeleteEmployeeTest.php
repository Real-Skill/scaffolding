<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use AppBundle\Tests\Traits\GetDataArrayFromJsonResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DeleteEmployeeTest
 * @package AppBundle\Tests\Feature
 */
class DeleteEmployeeTest extends AbstractFixtureAwareWebTestCase
{
    use GetDataArrayFromJsonResponseTrait;

    /**
     * @test
     */
    public function shouldReturn404IfEmployeeNotExistsAndJsonWithPropertyStatusSetToFalse()
    {
        $expectedData = [
            'success' => false,
        ];

        $response = $this->deleteEmployeeById(4);
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode(), 'Should return NOT_FOUND status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldDeleteCertainEmployee()
    {
        $expectedData = [
            'success' => true,
        ];
        $expectedEmployees = [
            [
                'id' => 1,
                'name' => 'Martin',
                'surname' => 'Fowler',
                'email' => 'martin.fowler@fake.pl',
                'bio' => 'A British software developer, author and international public speaker on software development, specializing in object-oriented analysis and design, UML, patterns, and agile software development methodologies, including extreme programming.',
                'daysInOffice' => 2,
            ],
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

        $response = $this->requestList();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedEmployees, $this->getDataArrayFromJsonResponse());

        $response = $this->deleteEmployeeById(2);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());

        $response = $this->requestList();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals([$expectedEmployees[0], $expectedEmployees[2]], $this->getDataArrayFromJsonResponse());

        $response = $this->deleteEmployeeById(3);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());

        $response = $this->requestList();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals([$expectedEmployees[0]], $this->getDataArrayFromJsonResponse());

        $response = $this->deleteEmployeeById(1);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());

        $response = $this->requestList();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals([], $this->getDataArrayFromJsonResponse());
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadEmployeeData()];
    }

    /**
     * @return Response
     */
    protected function requestList()
    {
        $this->client->request('GET', '/api/employee');

        return $this->client->getResponse();
    }

    /**
     * @param int $id
     * @return Response
     */
    protected function deleteEmployeeById($id)
    {
        $this->client->request('DELETE', '/api/employee/'.$id);

        return $this->client->getResponse();
    }
}
