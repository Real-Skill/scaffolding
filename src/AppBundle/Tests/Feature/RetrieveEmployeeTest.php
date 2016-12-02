<?php

namespace AppBundle\Tests\Feature;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RetrieveEmployeeTest
 * @package AppBundle\Tests\Feature
 */
class RetrieveEmployeeTest extends AbstractFixtureAwareWebTestCase
{
    /**
     * @test
     */
    public function shouldReturnEmployeesArray()
    {
        $expectedData = [
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

        $this->assertEquals('application/json', $this->client->getResponse()->headers->get('Content-Type'));

        $returnedData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals($expectedData, $returnedData);
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [new LoadEmployeeData()];
    }

    /**
     * @before
     */
    protected function doGetRequestAndAssertOkStatusCode()
    {
        $this->crawler = $this->client->request('GET', '/api/employee');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}
