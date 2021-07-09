<?php

namespace App\Controller;

use App\Entity\College;
use App\Form\CollegeType;
use App\Repository\CollegeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/college")
 */
class CollegeController extends AbstractController
{
    /**
     * @Route("/", name="college_index", methods={"GET"})
     */
    public function index(CollegeRepository $collegeRepository): Response
    {
        return $this->render('college/index.html.twig', [
            'colleges' => $collegeRepository->findAll(),
        ]);
    }
/**
 * @Route("/new", name="college_new", methods={"GET", "POST"})
 */
    public function new(Request $request): Response
    {
        $college = new College();
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($college);
            $entityManager->flush();

            return $this->redirectToRoute('college_index');
        }

        return $this->render('college/new.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }
/**
 * @Route("/{id}", name="college_show", methods={"GET"})
 */
    public function show(College $college): Response
    {
        return $this->render('college/show.html.twig', [
            'college' => $college,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="college_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, College $college): Response
    {
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('college_index');
        }

        return $this->render('college/edit.html.twig', [
            'college' => $college,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="college_delete", methods={"POST"})
     */
    public function delete(Request $request, College $college): Response
    {
        if ($this->isCsrfTokenValid('delete' . $college->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($college);
            $entityManager->flush();
        }

        return $this->redirectToRoute('college_index');
    }
}
