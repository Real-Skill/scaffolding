<?php

namespace AppBundle\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ViolationListConverter
 * @package AppBundle\Service
 */
class ViolationListConverter
{
    /**
     * @param ConstraintViolationListInterface $errors
     * @return array
     */
    public function convertToArray(ConstraintViolationListInterface $errors)
    {
        $errorsArray = [];

        if ($errors->count()) {
            foreach ($errors as $error) {
                $errorsArray[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        return $errorsArray;
    }
}
