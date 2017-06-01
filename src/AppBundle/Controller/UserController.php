<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcherInterface;

class UserController extends Controller
{
    /**
     * @return string
     *
     * @FosRest\Get("/users")
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->findAll();

        return $users;
    }

    /**
     * @return string
     *
     * @FosRest\Get("/users/{id}")
     */
    public function getUserAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:User')
                ->find($request->get('id'));
        /* @var $user User */

        return $user;
    }

    /**
     * @FosRest\View(statusCode=Response::HTTP_CREATED)
     * @FosRest\Post("/signup")
     * @RequestParam(name="pseudonyme", nullable=false, description="test")
     * @RequestParam(name="email", nullable=false, description="test")
     * @RequestParam(name="password", nullable=false, description="test")
     */
    public function postUsersAction(ParamFetcherInterface $paramFetcher)
    {
        $user = new User();

        $user->setPseudonyme($paramFetcher->get('pseudonyme'));
        $user->setEmail($paramFetcher->get('email'));
        $user->setPassword($paramFetcher->get('password'));
        $user->setStatus(1);

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();
        //     return $user;
        // } else {
        //     return $form;
        // }
    }

}
