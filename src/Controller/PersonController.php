<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            /** @var array{firstName: string, lastName: string, email: string} $person */
            $rawPerson = $request->request->all('person');

            $person = Person::createPerson($rawPerson);

            $this->personRepository->create($person);

            return $this->redirectToRoute('person_index');
        }
        return $this->render('person/create.html.twig');
    }
}
