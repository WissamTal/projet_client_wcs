<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\LegalPerson;
use App\Form\LegalPersonType;
use App\Repository\LegalPersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/legalPerson", name="legalPerson_")
 */
class LegalPersonController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(LegalPersonRepository $legalPersonRepository): Response
    {
        return $this->render('legal_person/index.html.twig', [
            'legal_people' => $legalPersonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $legalPerson = new LegalPerson();
        $form = $this
            ->createForm(LegalPersonType::class, $legalPerson)
            ->remove('mainRepresentative')
            ->remove('secondRepresentative');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($legalPerson);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }

            return $this->redirectToRoute('members_index');
        }

        $template = $request->isXmlHttpRequest() ? '_legalform.html.twig' : 'new.html.twig';

        return $this->render('members/' . $template, [
            'legal_person' => $legalPerson,
            'form' => $form->createView(),
        ], new Response(
            null,
            $form->isSubmitted() ? 422 : 200
        ));
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(LegalPerson $legalPerson): Response
    {
        if ($this->getUser()->getStructure()->getId() == $legalPerson->getStructure()->getId()) {
            return $this->render('legal_person/show.html.twig', [
                'legalPerson' => $legalPerson,
            ]);
        }
        return $this->redirectToRoute('members_index');
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LegalPerson $legalPerson): Response
    {
        $form = $this->createForm(LegalPersonType::class, $legalPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('legal_person_index');
        }

        return $this->render('legal_person/edit.html.twig', [
            'legal_person' => $legalPerson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, LegalPerson $legalPerson): Response
    {
        if ($this->isCsrfTokenValid('delete' . $legalPerson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($legalPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('legal_person_index');
    }
}
