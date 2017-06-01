<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PageRevision;
use AppBundle\Form\PageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as FosRest;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use AppBundle\Entity\Page;
use Symfony\Component\Validator\Constraints\Time;

class PageController extends Controller
{
    public function slugify($string)
    {
        $rule = 'NFD; [:Nonspacing Mark:] Remove; NFC';
        $transliterator = \Transliterator::create($rule);
        $string = $transliterator->transliterate($string);

        return preg_replace(
            '/[^a-z0-9]/',
            '-',
            strtolower(trim(strip_tags($string)))
        );
    }

    /**
     * @return string
     *
     * @FosRest\Get("/page")
     */
    public function getAction(){

        $page = new Page();
        return $page;
    }

    /**
     *
     * @FosRest\Get("/page/{slug}")
     */
    public function getActionSingle(Request $request){
        $em = $this->get('doctrine.orm.entity_manager');
        $page = $em->getRepository('AppBundle:Page')
            ->find($request->get('slug'));

        return $page;
    }

    /**
     *
     * @Post("/page")
     */
    public function postPageAction(Request $request)
    {
        $page = new Page();
        $pageRevision = new PageRevision();
        $form = $this->createForm(PageType::class, $pageRevision);

        $form->submit($request->request->all());
        $data = $form->getData();

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $page->setCreatedAt(new \DateTime());
            $page->setUpdatedAt(new \DateTime());
            $page->setSlug($this->slugify($data->title));

            $em->persist($page);
            $em->flush();

            $pageRevision->setPageId($page->getId());
            $pageRevision->setTitle($data->title);
            $pageRevision->setContent($data->content);
            $pageRevision->setStatus('online');
            $pageRevision->setUpdatedBy('');
            $pageRevision->setCreatedAt(new \DateTime());
            $pageRevision->setUpdatedAt(new \DateTime());
            $em->persist($pageRevision);
            $em->flush();

            return $page;
        } else {
            return $form;
        }
    }

    /**
     *
     * @Delete("/page/{id}")
     */
    public function removePlaceAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $page = $em->getRepository('AppBundle:Page')
            ->find($request->get('id'));

        $em->remove($page);
        $em->flush();

        return 'lol';
    }

    /**
     * @Put("/page/{id}")
     */
    public function updatePageAction(Request $request)
    {
        $page = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Page')
            ->find($request->get('id'));

        if (empty($page)) {
            return new JsonResponse(['message' => 'Page not found'], Response::HTTP_NOT_FOUND);
        }

        $pageRevision = new PageRevision();

        $form = $this->createForm(PageType::class, $pageRevision);
        $form->submit($request->request->all());

        $data = $form->getData();


        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $pageRevision->setPageId($page->id);
            $pageRevision->setTitle($data->title);
            $pageRevision->setContent($data->content);
            $pageRevision->setStatus('online');
            $pageRevision->setUpdatedBy('');
            $pageRevision->setCreatedAt(new \DateTime());
            $pageRevision->setUpdatedAt(new \DateTime());
            $em->persist($pageRevision);
            $em->flush();
            $page->setUpdatedAt(new \DateTime());
            $em->flush();
            return $page;
        } else {
            return $form;
        }
    }
}