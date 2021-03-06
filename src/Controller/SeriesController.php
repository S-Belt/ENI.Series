<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class SeriesController extends AbstractController
{
    /**
     * @Route("/series", name="serie_list")
     */
    public function list(SerieRepository $serieRepository): Response
    {
        //$series = $serieRepository->findAll(); Toutes les series
        //en options on met le tri par popularit√©, ensuite par votes et on limita a 30 resultats

        //$series = $serieRepository->findBy([], ['popularity' => 'DESC', 'vote' => 'DESC'], 30);

        //on peut creer un nouveau filtre dans serieRepository et l'appliquer ici
        $series = $serieRepository->findBestSeries();

        return $this->render('series/list.html.twig', [
            "series" => $series

        ]);
    }

    /**
     * @Route("/series/details/{id}", name="serie_details")
     */
    public function details(int $id, SerieRepository $serieRepository): Response
    {
        //on recupere l'ID de la serie depuis la bdd
        $serie = $serieRepository->find($id);

        //on verifie que la serie existe(ex. apres une suppression)
        if(!$serie){
            throw $this->createNotFoundException('sorry');
        }


        //puis on passe la valeur a twig
        return $this->render('series/details.html.twig', [
            "serie" => $serie
        ]);
    }

    /**
     * @Route("/series/create", name="serie_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        //apres avoir cree notre formulaire SerieType on commence par creer une instance de Serie
        $serie = new Serie();
        $serie->setDateCreated(new \DateTime());
        
        //ensuite une instance de notre formulaire en appelant la methode createForm
        //type de form et on l'associe a $serie
        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request); //la on demande d'injecter nos valeurs dans $series

        if($serieForm->isSubmitted() && $serieForm->isValid()){

            $entityManager->persist($serie); //enregistrer nos valeurs dans la bdd
            $entityManager->flush();
            
            $this->addFlash('success', 'Serie Added');
            return $this->redirectToRoute('serie_details', ['id' => $serie->getId()]);


        }


        return $this->render('series/create.html.twig', [
            'serieForm' => $serieForm->createView() //na pas oublier de mettre le 'createwiew pour l'affichage
        ]);


    }

    /**
     * @Route ("/series/demo", name="em-demo")
     */

    public function demo(EntityManagerInterface $entityManager): Response
    {
        //cr√©e une instance de mon entit√©

        $serie = new Serie();

        //hydrate toutes les propri√©tes

        $serie->setName('HolyMoly');
        $serie->setBackdrop('dafsd');
        $serie->setPoster('dafsdf');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime("-1 year"));
        $serie->setLastAirDate(new \DateTime("+6 month"));
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
        //supprimer la serie cr√©e
        //$entityManager->remove($serie);
        //$entityManager->flush();

        //si, au lieu de supprimer la nouvelle serie on decide de changer un champ
        $serie->setGenres('comedy');
        $entityManager->flush();

         return $this->render('series/create.html.twig');

    }

    /**
     * @Route ("/serie/delete/{id}", name"series_delete")
     */

    /*public function delete(Serie $serie, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($serie);
        $entityManager->flush();

        return $this->redirectToRoute('main_home');
    }*/


}
