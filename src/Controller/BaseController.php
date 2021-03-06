<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Form\ReservationType2;
use App\Repository\ArticleRepository;
use App\Repository\ReservationRepository;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexArticle(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy([],['title' => 'ASC']);
        return $this->render('base/article_index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/recherche", name="search_article")
     */
    public function rechercheArticle(ArticleRepository $ar, Request $request) : Response
    {
        $term = $request->query->get('s');
        $searchedArticles = $ar->findArticleByTerm($term);
        return $this->render('base/article_index.html.twig', [
            'articles' => $searchedArticles
        ]);
    }

    
    /**
     * @Route("/article/{id}", name="show_article", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('base/article_show.html.twig', [
            'article' => $article,
        ]);
    }

     /**
     * @Route("/article/{id}/reservation", name="reservation_article_connu")
     */

    public function reservationArticleConnu(Article $article, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType2::class, $reservation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            if($reservation->getStartAt() < $reservation->getEndAt()) {
                $reservation->setReservedBy($this->getUser());
                $reservation->setReturned(false);
                $reservation->setArticle($article);
                $em->persist($reservation);
                $em->flush();
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('error','Problème');
            }
        }
        return $this->render('base/article_reservation.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);   
    }





}
