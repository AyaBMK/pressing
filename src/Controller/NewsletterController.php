<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Services\NewsletterSubscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{ 
    #[Route('/api/newsletter', name: 'app_newsletter', methods: ['POST'])]
    public function subscribe(Request $request, EntityManagerInterface $em): Response
    {
        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $newsletter->setSubscribed(true);
            $newsletter->setSubscriptionDate(new \DateTime());
            $em->persist($newsletter);
            $em->flush();
            
        }

       
        return $this->json($newsletter);
    }
}
