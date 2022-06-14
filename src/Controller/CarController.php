<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarFormType;
use App\Repository\CarRepository;
use App\Service\CarService;
use App\Service\UploadImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cars', name: 'car_')]
class CarController extends AbstractController
{
    private CarRepository $carRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CarService $carService, CarRepository $carRepository, EntityManagerInterface $entityManager)
    {
        $this->carRepository = $carRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'list')]
    public function index(): Response
    {
        $cars = $this->carRepository->findAll();
        return $this->render('cars/index.html.twig', [
            'cars' => $cars
        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'])]
    public function show(Car $car): Response
    {
        return $this->render('cars/show.html.twig', [
            'car' => $car
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, UploadImageService $uploadImageService): Response
    {
        $car = new Car();
        $form = $this->createForm(CarFormType::class, $car);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {

            return $this->render('cars/create.html.twig', [
                'form' => $form->createView()
            ]);
        }
        $newCar = $form->getData();
        $image = $form->get('image')->getData();
        $imageName = $uploadImageService->upload($image);
        if ($imageName === "") {
            return new Response("Upload image fail");
        }
        $newCar->setImage('/uploads/' . $imageName);

        $this->entityManager->persist($newCar);
        $this->entityManager->flush();

        return $this->redirectToRoute('car_list');
    }
}
