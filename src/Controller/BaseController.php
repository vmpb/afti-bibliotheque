<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ArticleRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('base/index.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
    
    /**
     * @Route("/article", name="all_articles", methods={"GET"})
     */
    public function indexArticle(ArticleRepository $articleRepository): HttpFoundationResponse
    {
        $articles = $articleRepository->findBy([],['title' => 'ASC']);
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function userReservation(Request $request) : HttpFoundationResponse
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($reservation->getStartAt() < $reservation->getEndAt()) {
                $reservation->setReservedBy($this->getUser());
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
     * @Route("/mesreservations", name="userReservations")
     */
    public function getUserReservations(ReservationRepository $rr)
    {
        $user = $this->getUser();
        $reservations = $rr->findReservationByUser($user);
        return $this->render('base/reservations_utilisateur.html.twig', [
            'reservations' => $reservations,
        ]);
    }

}
