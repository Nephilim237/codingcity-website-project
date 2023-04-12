<?php

namespace App\EntityListener;

use App\Entity\Post\Category;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsEntityListener(event: Events::prePersist, entity: Category::class)]
#[AsEntityListener(event: Events::preUpdate, entity: Category::class)]
class CategoryEntityListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function prePersist(Category $category, LifecycleEventArgs $eventArgs): void
    {
        $category->computeSlug($this->slugger);
    }

    public function preUpdate(Category $category, LifecycleEventArgs $eventArgs): void
    {
        $category->computeSlug($this->slugger);
    }

}