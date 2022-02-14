<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SeriesController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(): Response
    {
        //todo: aller chercher les series en bdd
        return $this->render('series/list.html.twig', [

        ]);
    }

    /**
     * @Route("/series/details/{id}", name="serie_details")
     */
    public function details(int $id): Response
    {
        return $this->render('series/details.html.twig');
    }

    /**
     * @Route("/series/create", name="serie_create")
     */
    public function create(): Response
    {
        return $this->render('series/create.html.twig');
    }



}
