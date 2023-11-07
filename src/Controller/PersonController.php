<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use App\Entity\User;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use App\UseCase\Person\CreatePerson;
use App\UseCase\Person\CreatePersonInterface;
use App\UseCase\Person\DeletePerson;
use App\UseCase\Person\DeletePersonInterface;
use App\UseCase\Person\UpdatePerson;
use App\UseCase\Person\UpdatePersonInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(name: 'person_')]
class PersonController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PersonRepository $personRepository): Response
    {
        $persons = $personRepository->findAll();

        return $this->render('person/index.html.twig', ['persons' => $persons]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, CreatePersonInterface $createPerson): Response
    {
        $person = new Person();

        $form = $this->createForm(PersonType::class, $person)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createPerson->create($person);

            $this->addFlash('success', 'La personne a été ajoutée avec succès.');

            return $this->redirectToRoute('person_index');
        }
        return $this->render('person/create.html.twig', ['form' => $form]);
    }

    #[Route('/{id}/update', name: 'update', methods: ['GET', 'POST'])]
    #[IsGranted('UPDATE', subject: 'person')]
    public function update(Request $request, Person $person, UpdatePersonInterface $updatePerson): Response
    {
        $form = $this->createForm(PersonType::class, $person)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $updatePerson->update($person);

            $this->addFlash('success', 'La personne a été modifiée avec succès.');

            return $this->redirectToRoute('person_index');
        }
        return $this->render('person/update.html.twig', ['form' => $form]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    #[IsGranted('DELETE', subject: 'person')]
    public function delete(Request $request, Person $person, DeletePersonInterface $deletePerson): Response
    {
        $token = $request->request->get('_csrf_token');

        if ($this->isCsrfTokenValid('delete-person', $token)) {
            $deletePerson->delete($person);

            $this->addFlash('success', 'La personne a été supprimée avec succès.');
        }

        return $this->redirectToRoute('person_index');
    }
}
