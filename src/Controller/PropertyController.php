<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    private PropertyRepository $repository;

    public function __construct(ManagerRegistry $manager)
    {
        $this->repository = $manager->getRepository(Property::class);
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('bien/index.html.twig', [
            'properties' => $this->repository->findBy(['available' => true], ['id' => "DESC"], 5)
        ]);
    }
}
