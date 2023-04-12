<?php

namespace App\Controller;

use App\Entity\Post\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LikeController extends AbstractController
{
    #[Route('/like/post/{id}', name: 'cc_like')]
    #[IsGranted('ROLE_USER')]
    public function handleLike(Post $post, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        if ($post->isLikedByUser($user)) {
            $post->removeUserLike($user);
            $manager->flush();

            return $this->json([
                'numberOfLikes' => $post->howMuchLikes(),
            ]);
        }

        $post->addUserLike($user);
        $manager->flush();

        return $this->json([
            'numberOfLikes' => $post->howMuchLikes(),
        ]);
    }
}