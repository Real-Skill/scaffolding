<?php

namespace AppBundle\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Client;

/**
 * Class AbstractFixtureAwareWebTestCase
 * @package AppBundle\Tests
 */
abstract class AbstractFixtureAwareWebTestCase extends WebTestCase
{
    /**
     * ORMPurger::PURGE_MODE_*
     * @var int
     */
    protected $purgeMode = ORMPurger::PURGE_MODE_TRUNCATE;

    /**
     * @var ORMExecutor
     */
    protected $executor;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Crawler|null
     */
    protected $crawler;

    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @return array
     */
    abstract protected function getFixtures();

    protected function setUp()
    {
        $this->client = $this->createClient();

        $this->manager = $this->client->getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger($this->manager);

        $purger->setPurgeMode($this->purgeMode);

        $this->executor = new ORMExecutor($this->manager, $purger);

        $this->executor->execute($this->getFixtures());
    }
}
