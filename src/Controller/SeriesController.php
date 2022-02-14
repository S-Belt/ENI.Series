<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route ("/series/demo", name="em-demo")
     */

    public function demo(EntityManagerInterface $entityManager): Response
    {
        //crée une instance de mon entité

        $serie = new Serie();

        //hydrate toutes les propriétes

        $serie->setName('HolyMoly');
        $serie->setBackdrop('dafsd');
        $serie->setPoster('dafsdf');
        $serie->setDateCreated(new\ DateTime());
        $serie->setFirstAirDate(new\ DateTime("-1 year"));
        $serie->setLastAirDate(new\ DateTime("+6 month"));
        $serie->setGenres('drama');
        $serie->setOverview('very very good');
        $serie->setPopularity(123.00);
        $serie->setVote(8.2);
        $serie->setStatus('Canceled');
        $serie->setTmdbId(329432);

        dump($serie); //on peut verifier les infos avec un dump

        //les 2 operations d'entityManager pour faire notre 'insert' dans la bdd
        $entityManager->persist($serie);
        $entityManager->flush();

        dump($serie);
        //supprimer la serie crée
        //$entityManager->remove($serie);
        //$entityManager->flush();

        //si, au lieu de supprimer la nouvelle serie on decide de changer un champ
        $serie->setGenres('comedy');
        $entityManager->flush();




        return $this->render('series/create.html.twig');

    }



}
