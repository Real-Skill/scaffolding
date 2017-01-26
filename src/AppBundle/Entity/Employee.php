<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=64)
     * @ORM\Column(type="string", length=64)
     *
     * @var string
     */
    protected $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=64)
     * @ORM\Column(type="string", length=64)
     *
     * @var string
     */
    protected $surname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=254)
     * @Assert\Email()
     * @ORM\Column(type="string", length=254, unique=true)
     *
     * @var string
     */
    protected $email;

    /**
     * @Assert\Length(max=400)
     * @ORM\Column(type="string", length=400, nullable=true)
     *
     * @var string
     */
    protected $bio;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 2,
     *      max = 5,
     *      minMessage = "You must be at least {{ limit }} days working in the office.",
     *      maxMessage = "You cannot work more than {{ limit }} days in the office."
     * )
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    protected $daysInOffice;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Employee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Employee
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Employee
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set bio
     *
     * @param string $bio
     * @return Employee
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set daysInOffice
     *
     * @param int $daysInOffice
     * @return Employee
     */
    public function setDaysInOffice($daysInOffice)
    {
        $this->daysInOffice = $daysInOffice;

        return $this;
    }

    /**
     * Get daysInOffice
     *
     * @return int
     */
    public function getDaysInOffice()
    {
        return $this->daysInOffice;
    }
}
