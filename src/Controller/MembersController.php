<?php

namespace App\Controller;

use App\Service\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LegalPerson;
use App\Entity\NaturalPerson;
use App\Entity\Associate;
use App\Entity\OtherParticipant;
use App\Entity\Executive;
use App\Entity\Structure;
use App\Entity\User;
use App\Form\LegalPersonType;
use App\Form\MembersType;
use App\Form\NaturalPersonType;
use App\Form\SearchMembersFormType;
use App\Repository\LegalPersonRepository;
use App\Repository\NaturalPersonRepository;
use App\Repository\StructureRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/members", name="members_")
 */
class MembersController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(
        Request $request,
        NaturalPersonRepository $naturalPersonRepository,
        LegalPersonRepository $legalPersonRepository
    ): Response {
        if (null !== $this->getUser()) {
            $name = $this->getUser()->getStructure()->getName();
            $id = $this->getUser()->getStructure()->getId();
            $structureNatural = $naturalPersonRepository->findByPers($id);
            $structureLegal = $legalPersonRepository->findByPers($id);
            $template = $request->query->get('ajax') ? '_list.html.twig' : 'index.html.twig';
            $currentDate = Date('d-m-Y');

            return $this->render('members/' . $template, [
                'currentDate' => $currentDate,
                'structureNatural' => $structureNatural,
                'structureLegal' => $structureLegal,
                'name' => $name
            ]);
        }
        return  $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/{id}/editlegal", name="editLegal", methods={"GET","POST"})
     */
    public function editLegal(Request $request, LegalPerson $legalPerson): Response
    {
        $form = $this->createForm(LegalPersonType::class, $legalPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('members_index');
        }
        return $this->render('members/editlegal.html.twig', [
            'legalPerson' => $legalPerson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/editnatural", name="editNatural", methods={"GET","POST"})
     */
    public function editNatural(Request $request, NaturalPerson $naturalPerson): Response
    {
        $form = $this->createForm(NaturalPersonType::class, $naturalPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('members_index');
        }
        return $this->render('members/editnatural.html.twig', [
            'naturalPerson' => $naturalPerson,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/deleteLegal", name="deleteLegal", methods={"GET","POST"})
     */
    public function deleteLegal(Request $request, LegalPerson $legalPerson): Response
    {
        if ($this->isCsrfTokenValid('delete' . $legalPerson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($legalPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('members_index');
    }

    /**
     * @Route("/{id}/deleteNatural", name="deleteNatural", methods={"GET","POST"})
     */
    public function deleteNatural(Request $request, NaturalPerson $naturalPerson): Response
    {
        if ($this->isCsrfTokenValid('delete' . $naturalPerson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($naturalPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('members_index');
    }

    /**
     * @Route("/sendMail", name="sendMail")
     */

    public function sendMail($text)
    {

        $mail = new Mail();
        $mail->send($text, 'Wissam Taleb', 'TesT Mail', 'Bonjour Wissam');

        $this->addFlash('success', 'Mail Sent To Selection!');
        return $this->redirectToRoute('members_index');
    }
}
