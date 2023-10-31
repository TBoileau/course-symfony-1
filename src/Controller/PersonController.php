<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(name: 'person_')]
class PersonController extends AbstractController
{
    public function __construct(private readonly PersonRepository $personRepository)
    {
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $persons = $this->personRepository->findAll();

        return $this->render('person/index.html.twig', ['persons' => $persons]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        $person = new Person();

        $form = $this->createForm(PersonType::class, $person)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personRepository->create($person);

            return $this->redirectToRoute('person_index');
        }
        return $this->render('person/create.html.twig', ['form' => $form]);
    }
}
