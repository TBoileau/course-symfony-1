<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(name: 'person_')]
class PersonController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $persons = [];

        if (file_exists('persons.csv')) {
            $serializer = new Serializer(
                [new ArrayDenormalizer()],
                [new CsvEncoder()]
            );
            $persons = $serializer->decode(
                file_get_contents('persons.csv'),
                'csv',
                ['no_headers' => true]
            );
        }

        return $this->render('person/index.html.twig', ['persons' => $persons]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, SerializerInterface $serializer): Response
    {
        if ($request->isMethod('POST')) {
            /** @var array{firstName: string, lastName: string, email: string} $person */
            $person = $request->request->all('person');

            (new Filesystem())
                ->appendToFile(
                    'persons.csv',
                    $serializer->serialize($person, 'csv', ['no_headers' => true])
                )
            ;

            return $this->redirectToRoute('person_index');
        }
        return $this->render('person/create.html.twig');
    }
}
