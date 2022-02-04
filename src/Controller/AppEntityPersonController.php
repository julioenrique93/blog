<?php

namespace App\Controller;

use App\Entity\AppEntityPerson;
use App\Form\AppEntityPersonType;
use App\Repository\AppEntityPersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/app/entity/person")
 */
class AppEntityPersonController extends AbstractController
{
    /**
     * @Route("/", name="app_entity_person_index", methods={"GET"})
     */
    public function index(AppEntityPersonRepository $appEntityPersonRepository): Response
    {
        return $this->render('app_entity_person/index.html.twig', [
            'app_entity_people' => $appEntityPersonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_entity_person_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $appEntityPerson = new AppEntityPerson();
        $form = $this->createForm(AppEntityPersonType::class, $appEntityPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appEntityPerson);
            $entityManager->flush();

            return $this->redirectToRoute('app_entity_person_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('app_entity_person/new.html.twig', [
            'app_entity_person' => $appEntityPerson,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_entity_person_show", methods={"GET"})
     */
    public function show(AppEntityPerson $appEntityPerson): Response
    {
        return $this->render('app_entity_person/show.html.twig', [
            'app_entity_person' => $appEntityPerson,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_entity_person_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AppEntityPerson $appEntityPerson, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppEntityPersonType::class, $appEntityPerson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entity_person_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('app_entity_person/edit.html.twig', [
            'app_entity_person' => $appEntityPerson,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_entity_person_delete", methods={"POST"})
     */
    public function delete(Request $request, AppEntityPerson $appEntityPerson, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appEntityPerson->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appEntityPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entity_person_index', [], Response::HTTP_SEE_OTHER);
    }
}