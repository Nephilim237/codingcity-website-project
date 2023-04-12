<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class OwnerSubscriber implements EventSubscriberInterface
{
    const ROUTES = ['cc_blog', 'cc_single_blog'];

    public function __construct(private readonly UserRepository $userRepository, private readonly Environment $environment)
    {

    }

    #[NoReturn] public function injectOwner(RequestEvent $event)
    {
        $route = $event->getRequest()->get('_route');
        if (in_array($route, self::ROUTES)) {
            $owner = $this->userRepository->findOneBy(['owner' => true]);
            $this->environment->addGlobal('owner', $owner);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'injectOwner'];
    }
}