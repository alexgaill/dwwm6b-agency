<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Property;
use App\Form\AppointementType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController
{
    private PropertyRepository $repository;
    private ObjectManager $om;

    public function __construct(ManagerRegistry $manager)
    {
        $this->repository = $manager->getRepository(Property::class);
        $this->om = $manager->getManager();
    }

    #[Route('/', name: 'app_home', methods:["GET"])]
    public function index(): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $this->repository->findBy(['available' => true], ['id' => "DESC"], 5)
        ]);
    }

    #[Route("/property/{id}", name:"show_property", requirements:['id' => "\d+"], methods:["GET", "POST"])]
    public function show(int $id, Request $request): Response
    {
        $property = $this->repository->find($id);
        if (!$property) {
            $this->addFlash('danger', "Bien non trouvé");
            return $this->redirectToRoute('app_home');
        }

        $appointment = new Appointment;
        $contactForm = $this->createForm(AppointementType::class, $appointment);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $appointment->setProperty($property);
            $this->om->persist($appointment);
            $this->om->flush();
            return $this->redirectToRoute('show_property', ['id' => $property->getId()]);
        }

        return $this->renderForm('property/show.html.twig', [
            'property' => $property,
            'contactForm' => $contactForm
        ]);
    }
}
