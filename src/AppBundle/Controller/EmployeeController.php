<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class EmployeeController
 * @package AppBundle\Controller
 */
class EmployeeController extends Controller
{
    /**
     * @Route("/api/employee", name="employee_index")
     * @Method({"GET"})
     *
     * @return JsonResponse
     */
    public function indexAction()
    {
        /**
         * @var Employee[] $employees
         */
        $employees = $this->getRepo()->findAll();

        return new JsonResponse($this->get('serializer')->normalize($employees));
    }

    /**
     * @Route("/api/employee")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function newAction(Request $request)
    {
        /**
         * @var Employee $employee
         */
        $employee = $this->get('serializer')->denormalize($request->request->all(), Employee::class);

        return $this->validateEmployeeAndReturnResponse($employee);
    }

    /**
     * @Route("/api/employee/{employeeId}")
     * @Method({"PUT"})
     *
     * @param Request $request
     * @param int     $employeeId
     * @return JsonResponse
     */
    public function editAction(Request $request, $employeeId)
    {
        /**
         * @var Employee $employee
         */
        $employee = $this->getRepo()->find($employeeId);

        if (!$employee) {
            return new JsonResponse(['success' => false], JsonResponse::HTTP_NOT_FOUND);
        }

        $employee
            ->setName($request->request->get('name'))
            ->setSurname($request->request->get('surname'))
            ->setEmail($request->request->get('email'))
            ->setDaysInOffice($request->request->get('daysInOffice'))
            ->setBio($request->request->get('bio'));

        return $this->validateEmployeeAndReturnResponse($employee);
    }

    /**
     * @Route("/api/employee/{employeeId}")
     * @Method({"DELETE"})
     *
     * @param int|null $employeeId
     * @return JsonResponse
     */
    public function deleteAction($employeeId)
    {
        if (!$employeeId || !($employee = $this->getRepo()->find($employeeId))) {
            return new JsonResponse(['success' => false], JsonResponse::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($employee);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepo()
    {
        return $this->getDoctrine()->getRepository('AppBundle:Employee');
    }

    /**
     * @param Employee $employee
     * @return JsonResponse
     */
    protected function validateEmployeeAndReturnResponse(Employee $employee)
    {
        /**
         * @var ConstraintViolationList $errors
         */
        $errors = $this->get('validator')->validate($employee);

        if ($errors->count()) {
            return new JsonResponse([
                'success' => false,
                'errors' => $this->get('violation_list_converter')->convertToArray($errors),
            ], JsonResponse::HTTP_PRECONDITION_FAILED);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($employee);

        try {
            $em->flush();
        } catch (UniqueConstraintViolationException $exception) {
            return new JsonResponse([
                'success' => false,
                'errors' => ['email' => 'Such email exists in DB.'],
            ], JsonResponse::HTTP_CONFLICT);
        }

        return new JsonResponse([
            'success' => true,
            'id' => $employee->getId(),
        ]);
    }
}
