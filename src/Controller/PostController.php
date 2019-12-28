<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        //za Validaciju:
        $form->getErrors();
        //if ($form->isSubmitted() && $form->isValid()) {

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            //File uploading
            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachment'];
            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );

                $post->setImage($filename);
                $em->persist($post);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('post.index'));
        }

        //$post->setTitle('Test title!');
        //$em = $this->getDoctrine()->getManager();
        //$em->persist($post);
        //$em->flush();

        //return new Response('Post was created');
        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * @return Response
     */
    public function show(Post $post)
    {
        //$post = $postRepository->findPostWithCategory($id);
        //dump($post);
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function remove(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', 'Post was removed');

        return $this->redirect($this->generateUrl('post.index'));
    }


    /**
     * @Route ("/update/{id}", name="update")
     * methods={"GET","POST"}
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */

    public function update( Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        dump($post);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();


            //File uploading
            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachment'];
            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename
                );

                $post->setImage($filename);
                $em->flush();
            }

            return $this->redirect($this->generateUrl('post.index'));
        }

        return $this->render('post/update.html.twig', [
            'form' => $form->createView()
        ]);



    }
}
