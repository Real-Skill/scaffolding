<?php

namespace AppBundle\Tests\Feature;

use AppBundle\Tests\AbstractFixtureAwareWebTestCase;
use AppBundle\Tests\Traits\GetDataArrayFromJsonResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateEmployeeTest
 * @package AppBundle\Tests\Feature
 *
 * @SuppressWarnings(TooManyPublicMethods)
 */
class CreateEmployeeTest extends AbstractFixtureAwareWebTestCase
{
    use GetDataArrayFromJsonResponseTrait;

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfEmptyDataIsSend()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'name' => 'This value should not be blank.',
                'surname' => 'This value should not be blank.',
                'email' => 'This value should not be blank.',
                'daysInOffice' => 'This value should not be blank.',
            ],
        ];
        $response = $this->sendData([]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfAllSendEmployeePropertiesAreEmpty()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'name' => 'This value should not be blank.',
                'surname' => 'This value should not be blank.',
                'email' => 'This value should not be blank.',
                'daysInOffice' => 'This value should be a valid number.',
            ],
        ];
        $response = $this->sendData([
            'name' => '',
            'surname' => '',
            'email' => '',
            'bio' => '',
            'daysInOffice' => '',
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfNameIsToShort()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'name' => 'This value is too short. It should have 3 characters or more.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aa',
            'surname' => 'aaa',
            'email' => 'test@test.pl',
            'bio' => '',
            'daysInOffice' => 3,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfNameIsToLong()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'name' => 'This value is too long. It should have 64 characters or less.',
            ],
        ];
        $response = $this->sendData([
            'name' => str_repeat('a', 65),
            'surname' => 'aaa',
            'email' => 'test@test.pl',
            'bio' => '',
            'daysInOffice' => 3,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfSurnameIsToShort()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'surname' => 'This value is too short. It should have 3 characters or more.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => 'aa',
            'email' => 'test@test.pl',
            'bio' => '',
            'daysInOffice' => 3,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfSurnameIsToLong()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'surname' => 'This value is too long. It should have 64 characters or less.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => str_repeat('a', 65),
            'email' => 'test@test.pl',
            'bio' => '',
            'daysInOffice' => 3,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfEmailIsInvalid()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'email' => 'This value is not a valid email address.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => 'aaa',
            'email' => 'test',
            'bio' => '',
            'daysInOffice' => 3,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfEmailIsToLong()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'email' => 'This value is too long. It should have 254 characters or less.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => 'aaa',
            'email' => str_repeat('a', 247).'@test.pl', //length: 255
            'bio' => '',
            'daysInOffice' => 3,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfBioIsToLong()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'bio' => 'This value is too long. It should have 400 characters or less.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => 'aaa',
            'email' => 'test@test.pl',
            'bio' => str_repeat('a', 401),
            'daysInOffice' => 3,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfDaysInOfficeIsInvalid()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'daysInOffice' => 'This value should be a valid number.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => 'aaa',
            'email' => 'test@test.pl',
            'bio' => '',
            'daysInOffice' => 'a',
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfDaysInOfficeHasToLowValue()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'daysInOffice' => 'You must be at least 2 days working in the office.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => 'aaa',
            'email' => 'test@test.pl',
            'bio' => '',
            'daysInOffice' => 1,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @test
     */
    public function shouldReturnPreconditionFailedWithProperErrorsIfDaysInOfficeHasToHighValue()
    {
        $expectedData = [
            'success' => false,
            'errors' => [
                'daysInOffice' => 'You cannot work more than 5 days in the office.',
            ],
        ];
        $response = $this->sendData([
            'name' => 'aaa',
            'surname' => 'aaa',
            'email' => 'test@test.pl',
            'bio' => '',
            'daysInOffice' => 6,
        ]);

        $this->assertEquals(JsonResponse::HTTP_PRECONDITION_FAILED, $response->getStatusCode(), 'Should return PRECONDITION_FAILED status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

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
        $expectedData = [$data];

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
        $expectedData = [$data];

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode(), 'Should return OK(200) status code');
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedData, $this->getDataArrayFromJsonResponse());
    }

    /**
     * @return array
     */
    protected function getFixtures()
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return '/api/employee';
    }

    protected function getMethod()
    {
        return 'POST';
    }

    /**
     * @param array $data
     * @return Response
     */
    protected function sendData(array $data)
    {
        $this->client->request($this->getMethod(), $this->getPath(), $data);

        return $this->client->getResponse();
    }
}
