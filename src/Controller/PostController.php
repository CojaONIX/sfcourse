<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postRepository
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {
        $posts=$postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);

        //dump($posts);
        //return $this->render('post/index.html.twig', [
        //    'controller_name' => 'PostController',
        //]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $post = new Post();
        $post->setTitle('Test title!');

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();

        return new Response('Post was created');

    }

    /**
     * @Route("/show/{id}", name="show")
     * @param $id
     * @param PostRepository $postRepository
     * @return Response
     */
    //public function show(Post $post) //nece 1:42:30
    public function show($id, PostRepository $postRepository)
    {
        $post = $postRepository->find($id);
        //dump($post); die;
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);

    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function remove(Post $post){
        dump($post); die;
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirect($this->generateUrl('post.index'));

    }
}
