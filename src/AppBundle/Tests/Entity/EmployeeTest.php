<?php

namespace AppBundle\Tests\Entity;

use AppBundle\DataFixtures\ORM\LoadEmployeeData;
use AppBundle\Entity\Employee;
use AppBundle\Tests\AbstractFixtureAwareTestCase;

/**
 * Class EmployeeTest
 * @package AppBundle\Tests\Entity
 */
class EmployeeTest extends AbstractFixtureAwareTestCase
{
    /**
     * @test
     * @expectedException Doctrine\DBAL\Exception\NotNullConstraintViolationException
     */
    public function shouldNotAllowToSaveEmployeeWithoutName()
    {
        $employee = new Employee();
        $employee
            ->setSurname('aaa')
            ->setEmail('test@test.pl')
            ->setDaysInOffice(3);

        $em = self::getEntityManager();

        $em->persist($employee);
        $em->flush();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected static function getEntityManager()
    {
        return self::$kernel->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @before
     */
    protected function loadFixtures()
    {
        $this->executeFixtures([new LoadEmployeeData()]);
    }
}
