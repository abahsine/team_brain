<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Entity\UserTypeEnum;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSuccessEventSubscriber implements EventSubscriberInterface
{

    public function __construct(private readonly UrlGeneratorInterface $router, private RequestStack $request)
    {

    }

    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticatedToken()->getUser();
        if (!$user->isVerified()) {
            $this->request->getSession()->getFlashBag()->add('info', 'Votre compte n\'est pas encore validé, veuillez consulter vos mails et cliquer sur le lien de validation.');
            $url = $this->router->generate('app_logout');
            $event->setResponse(new RedirectResponse($url));
        }

        if ($user->getType() === UserTypeEnum::Unknown->value || $user->getNom() == "" || $user->getPrenom() == "") {
            $this->request->getSession()->getFlashBag()->add('info', 'Votre compte n\'est pas complet veuillez renseigner les informations manquantes.');
            $url = $this->router->generate('app_user_edit', ["id" => $user->getId()]);
            $event->setResponse(new RedirectResponse($url));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}
