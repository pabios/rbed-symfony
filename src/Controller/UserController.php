<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(MailerInterface $mailer): Response
    {

        $message = (new Email())
        ->from('baldeismaila2022@gmail.com@gmail.com')
        ->to(' baldeismaila2022@gmail.com')
        ->subject('welcome')
        ->text('Sender : baldeismaila2022@gmail.com',
        'text/plain');
        $mailer->send($message);
        
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
