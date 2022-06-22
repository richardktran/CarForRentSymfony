<?php

namespace App\Controller\API;

use App\Request\ImageRequest;
use App\Service\ImageService;
use App\Traits\JsonResponseTrait;
use App\Transformer\ImageTransformer;
use App\Transformer\ValidatorTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImageController extends AbstractController
{
    use JsonResponseTrait;

    private ValidatorTransformer $validatorTransformer;

    public function __construct(ValidatorTransformer $validatorTransformer)
    {
        $this->validatorTransformer = $validatorTransformer;
    }

    #[Route('/image', name: 'add_image', methods: ['POST'])]
    public function add(
        Request $request,
        ImageService $imageService,
        ImageTransformer $imageTransformer,
        ImageRequest $imageRequest,
        ValidatorInterface $validator
    ): JsonResponse {
        $file = $request->files->get('image');
        $imageRequest = $imageRequest->setImage($file);
        $errors = $validator->validate($imageRequest);
        if (count($errors) > 0) {
            $errorsTransformer = $this->validatorTransformer->toArray($errors);
            return $this->error($errorsTransformer);
        }
        $image = $imageService->upload($file);
        $imageResult = $imageTransformer->toArray($image);

        return $this->success($imageResult);
    }
}
