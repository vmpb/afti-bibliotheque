<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ArticleSearchType;
use App\Form\ReservationType2;
use App\Repository\ArticleRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{


    /**
     * @Route("/reservation", name="reservation")
     */
    public function userReservation(Request $request) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType2::class, $reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($reservation->getStartAt() < $reservation->getEndAt()) {
                $reservation->setReservedBy($this->getUser());
                $reservation->setReturned(false);
                $em->persist($reservation);
                $em->flush();
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('error','Problème');
            }
        }   
        return $this->render('base/reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        
    /**
     * @Route("/reservation/delete/{id}", name="reservation_delete")
     */
    public function deleteUserReservation(Reservation $reservation)  {

        $em = $this->getDoctrine()->getManager();
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('userReservations');
    
    }

    /**
     * @Route("/mesreservations", name="userReservations")
     */
    public function getUserReservations(ReservationRepository $rr) : Response
    {
        $user = $this->getUser();
        $reservations = $rr->findReservationByUser($user);
        return $this->render('base/reservations_utilisateur.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/search/reservation", name="searchandreserve", methods={"GET","POST"})
     */
    public function searchAndReserve(ArticleRepository $ar, Request $request) 
    {
        $form = $this->createForm(ArticleSearchType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $title = $form["Title"]->getData();
            $articles = $ar->findArticleByTerm($title);
            $nbArticles = count($articles);
            dump($articles, $nbArticles);
            if($nbArticles == 1) {
                return $this->redirectToRoute('show_article',['id' => $articles[0]->getId()]);
            } else {
                return $this->render('base/article_index.html.twig', [
                    'articles' => $articles,
                ]);
            }
        }

        return $this->render('base/reservations_recherche.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
