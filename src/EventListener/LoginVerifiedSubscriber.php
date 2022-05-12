<?php

namespace App\EventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
/**
 * Deuxieme methode celle que j'utilise
 */
class LoginVerifiedSubscriber implements EventSubscriberInterface
{
   
    public static function getSubscribedEvents()
    {
        return [
           AuthenticationSuccessEvent::class => 'onAuthenticationSuccess'
        ];
    }
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event){

        $user = $event->getAuthenticationToken()->getUser();
        if (!$user->isVerified()) {            
                throw new AuthenticationException("Merci de vérifier vos email et valider votre compte.");
        }
    }
}