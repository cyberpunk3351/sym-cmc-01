<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Menu;
use App\Entity\Post;
use App\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends AbstractController


{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->findAll();
        $menu = $em->getRepository(Menu::class)->findAll();
        $tag = $em->getRepository(Tag::class)->findAll();


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'post'=>$post,
            'menu'=>$menu,
            'tag'=>$tag,
        ]);

    }

    /**
     * @Route("/post/single/{post}", name="single")
     */
    public function single(Post $post)
    {
        return $this->render('default/single.html.twig', [
            'post'=>$post

        ]);
    }

    /**
     * @Route("/category/{category}", name="category")
     */
    public function category(Category $category)
    {
        return $this->render('default/category.html.twig', [
            'category' => $category,
            'posts' => $this->getDoctrine()->getManager()->getRepository(Post::class)->findBy(['category' => $category])
        ]);
    }


    /**
     * @Route("/tag/{id}", name="tag", methods={"GET"})
     */
    public function show(Tag $tag): Response
    {
        return $this->render('default/tag.html.twig', [
            'tag' => $tag,
//            'tag' => $this->getDoctrine()->getManager()->getRepository(Tag::class)->findBy(['tags' => $tag])

        ]);
    }

}
