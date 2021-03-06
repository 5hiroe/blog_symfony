<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @var ArticleRepository
     */

    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/article", name="article")
     */
    public function index(SessionInterface $session): Response
    {
        $articles = $this->articleRepository->findAll();
        $session->set('typefav', 'article');


        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
