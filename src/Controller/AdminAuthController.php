<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Article;
use App\Entity\Categories;

class AdminAuthController extends AbstractController
{
    /**
     * @Route("/admin/login", name="app_admin_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_account');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/admin-login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        // return $this->render('security/admin-login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
    * @Route("/admin/personal_account", name="admin_account")
    */

    public function admin_account(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('security/personal-admin-account.html.twig', [
            'controller_name' => 'AdminAuthController',
        ]);
     }

    /**
    * @Route("/admin/personal_account/addarticle", name="admin_add_article")
    */

    public function admin_add_article(): Response
    {
       $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

      $all_categories = $this->getDoctrine()
           ->getRepository(Categories::class)
           ->findAll();

      return $this->render('article/article-form.html.twig', [
         'controller_name' => 'AdminAuthController',
         'all_categories' => $all_categories,
      ]);
    }

    /**
    * @Route("/admin/personal_account/addarticle", name="add_article",  methods={"POST"})
    */

    public function addArticle(ArticleService $service, Request $request){

      $post_data = $request->request->all();

      $article = new Article();
      $article->setTitle($post_data['title']);
      $article->setText($post_data['text']);
      $article->setCreatedOn(new \DateTime('now'));
      $category_by_id = $this->getDoctrine()
          ->getRepository(Categories::class)
          ->find($post_data['categories']);
      $article->setCategory($category_by_id);

      $entity_manager = $this->getDoctrine()->getManager();
      $entity_manager->persist($article);

      $files = $request->files->get('images');
      foreach ($files as $file){
          $file_name = 'уникальное_имя.' . $file->guessExtension();
          $file->move(
              $this->getParameter('article_images'),
              $file_name
          );
          $img = new Images();
          $img->setSrc($file_name);
          $img->setAlt($file->getClientOriginalName());
          $img->addArticle($article);
          $entity_manager->persist($img);
      }

      $entity_manager->flush();

      return $this->json([
          'answer' => 'Данные добавлены',
          'id' => $article->getId()
      ]);
  }


}
