<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/", name="landing_")
*/
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function landing(): Response
    {
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing(): Response
    {
        return $this->render('home/pricing.html.twig');
    }
    /**
     * @Route("/features", name="features")
     */
    public function features(): Response
    {
        return $this->render('home/features.html.twig');
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($this->getParameter('admin_address'))
                ->to($this->getParameter('admin_address'))
                ->subject('Le Juriste Moderne : vous avez reçu un email')
                ->html($this->renderView('home/contactEmail.html.twig', ['contactFormData' => $contactFormData]));
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('landing_contact');
        }

        return $this->render('home/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/index.html.twig');
    }
}
