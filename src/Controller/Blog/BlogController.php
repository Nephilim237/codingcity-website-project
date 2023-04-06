<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Repository\Post\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @param PostRepository $postRepository
     * @param Request $request
     * @return Response
     */
    #[Route('/blog', name: 'cc_blog')]
    public function index(PostRepository $postRepository, Request $request): Response
    {

        return $this->render('blog/index.html.twig', [
            'posts' => $postRepository->getActivePost($request->query->getInt('page', 1), 10),
        ]);
    }

    #[Route('/blog/{slug}', name: 'cc_single_blog')]
    public function single(Post $post): Response
    {
        return $this->render('blog/single.html.twig', [
            'post' => $post
        ]);
    }
}
