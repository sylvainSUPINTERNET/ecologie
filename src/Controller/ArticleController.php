<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



use App\Form\AddArticleForm;





class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article")
     */
    public function index(Request $request)
    {
        $article = new Article();
        $formArticle = $this->createForm(AddArticleForm::class, $article);

        $formArticle->handleRequest($request);

        if($formArticle->isSubmitted() && $formArticle->isValid()){
            $article  = $formArticle->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();



            return $this->json([
                "error" => false,
                "message" => "article added with success",
                "code_http" => 200
            ]);
        }



        //return new Response('Welcome to your new controller!');
        return $this->render('test.html.twig', array(
           'test' => "bonjour",
            'article_form_add' =>  $formArticle->createView(),
        ));
    }


    /**
     * @Route("/api/hello/{name}" , name="hello")
     */
    public function apiExample($name)
    {
        return $this->json([
            'name' => $name,
            'symfony' => 'rocks',
        ]);
    }
}
