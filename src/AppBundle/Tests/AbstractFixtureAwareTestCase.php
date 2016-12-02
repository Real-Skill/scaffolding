<?php

namespace AppBundle\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class AbstractFixtureAwareTestCase
 * @package AppBundle\Tests
 */
abstract class AbstractFixtureAwareTestCase extends KernelTestCase
{
    /**
     * @var ORMExecutor
     */
    protected $fixtureExecutor;

    /**
     * init symfony kernel
     */
    public function setUp()
    {
        self::bootKernel();
    }

    /**
     * @param array $fixtures
     */
    protected function executeFixtures(array $fixtures)
    {
        $this->getFixtureExecutor()->execute($fixtures);
    }

    /**
     * @return ORMExecutor
     */
    protected function getFixtureExecutor()
    {
        if (!$this->fixtureExecutor) {
            /** @var \Doctrine\ORM\EntityManager $entityManager */
            $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();
            $purger = new ORMPurger($entityManager);

            $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);

            $this->fixtureExecutor = new ORMExecutor($entityManager, $purger);
        }

        return $this->fixtureExecutor;
    }
}
