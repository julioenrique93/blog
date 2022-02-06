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
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/app/entity/person")
 */
class AppEntityPersonController extends AbstractController
{
    /**
     * @Route("/app/entity/person", name="person_index")
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
//    /**
//     * @Route("/app/entity/person/new", name="person_mew")
//     */
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $appEntityPerson = new AppEntityPerson();
        $form = $this->createForm(AppEntityPersonType::class, $appEntityPerson);
        $form->handleRequest($request);
        $errors = $validator->validate($appEntityPerson);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appEntityPerson);
            $entityManager->flush();

            return $this->redirectToRoute('person_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('app_entity_person/new.html.twig', [
            'app_entity_person' => $appEntityPerson,
            'form' => $form,
            'errors' => $errors,
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
     * @Route("/app/entity/person/{id}/edit", name="person_edit")
     */
    public function edit(Request $request, AppEntityPerson $appEntityPerson, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(AppEntityPersonType::class, $appEntityPerson);
        $form->handleRequest($request);
        $errors = $validator->validate($appEntityPerson);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('person_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('app_entity_person/edit.html.twig', [
            'app_entity_person' => $appEntityPerson,
            'form' => $form,
            'errors' => $errors,
        ]);
    }
    /**
     * @Route("/app/entity/person/{id}", name="person_delete")
     */
    public function delete(Request $request, AppEntityPerson $appEntityPerson, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appEntityPerson->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appEntityPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('person_index', [], Response::HTTP_SEE_OTHER);
    }
}
