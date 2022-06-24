<?php

namespace App\Controller\API;

use App\Request\Rent\AddRentRequest;
use App\Service\RentService;
use App\Traits\JsonResponseTrait;
use App\Transformer\RentTransformer;
use App\Transformer\ValidatorTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/rents', name: 'rent_')]
class RentController extends AbstractController
{
    use JsonResponseTrait;

    private ValidatorInterface $validator;
    private ValidatorTransformer $validatorTransformer;

    public function __construct(ValidatorInterface $validator, ValidatorTransformer $validatorTransformer)
    {
        $this->validator = $validator;
        $this->validatorTransformer = $validatorTransformer;
    }

    #[Route('/', name: 'make', methods: ['POST'])]
    public function rent(
        Request $request,
        AddRentRequest $addRentRequest,
        RentTransformer $rentTransformer,
        RentService $rentService
    ): JsonResponse {
        $requestBody = json_decode($request->getContent(), true);
        $rentRequest = $addRentRequest->fromArray($requestBody);
        $errors = $this->validator->validate($rentRequest);
        if (count($errors) > 0) {
            $errorsTransformer = $this->validatorTransformer->toArray($errors);

            return $this->error($errorsTransformer);
        }
        $newRent = $rentService->rent($rentRequest);
        $newRent = $rentTransformer->toArray($newRent);

        return $this->success($newRent);
    }
}
