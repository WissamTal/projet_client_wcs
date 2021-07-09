<?php

namespace App\Controller;

use App\Entity\NaturalPerson;
use App\Form\NaturalPersonType;
use App\Repository\NaturalPersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/naturalPerson", name="naturalPerson_")
 */
class NaturalPersonController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(NaturalPersonRepository $naturalPersonRepository): Response
    {
        return $this->render('natural_person/index.html.twig', [
            'natural_people' => $naturalPersonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $naturalPerson = new NaturalPerson();
        $form = $this->createForm(NaturalPersonType::class, $naturalPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($naturalPerson);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new Response(null, 204);
            }

            return $this->redirectToRoute('members_index');
        }

        $template = $request->isXmlHttpRequest() ? '_naturalform.html.twig' : 'new.html.twig';

        return $this->render('members/' . $template, [
            'natural_person' => $naturalPerson,
            'form' => $form->createView(),
        ], new Response(
            null,
            $form->isSubmitted() ? 422 : 200
        ));
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(NaturalPerson $naturalPerson): Response
    {
        if ($this->getUser()->getStructure()== $naturalPerson->getStructureMember()) {
            return $this->render('natural_person/show.html.twig', [
                'naturalPerson' => $naturalPerson,
            ]);
        }
        return $this->redirectToRoute('members_index');
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NaturalPerson $naturalPerson): Response
    {
        $form = $this->createForm(NaturalPersonType::class, $naturalPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('natural_person_index');
        }

        return $this->render('natural_person/edit.html.twig', [
            'natural_person' => $naturalPerson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, NaturalPerson $naturalPerson): Response
    {
        if ($this->isCsrfTokenValid('delete' . $naturalPerson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($naturalPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('natural_person_index');
    }
}
