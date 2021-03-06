<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Images;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ArticleController extends AbstractController
{
     /**
     * @Route("/categories", name="categories")
     */
    public function select_category(): Response
    {

      $all_categories = $this->getDoctrine()
          ->getRepository(Categories::class)
          ->findAll();

        return $this->render('article/categories.html.twig', [
            'controller_name' => 'ArticleController',
            'all_categories' => $all_categories,
        ]);
    }

    // /**
    //  * @Route("/article", name="article")
    //  */
    // public function article(): Response
    // {
    //     return $this->render('article/article-form.html.twig', [
    //         'controller_name' => 'ArticleController',
    //     ]);
    // }

}
