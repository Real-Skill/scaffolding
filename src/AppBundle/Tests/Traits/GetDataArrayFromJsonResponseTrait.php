<?php

namespace AppBundle\Tests\Traits;

use Symfony\Component\HttpKernel\Client;

/**
 * @property Client client
 */
trait GetDataArrayFromJsonResponseTrait
{
    /**
     * @return array
     */
    protected function getDataArrayFromJsonResponse()
    {
        return json_decode($this->client->getResponse()->getContent(), true);
    }
}
