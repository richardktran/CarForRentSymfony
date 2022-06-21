<?php

namespace App\Controller\API;

use App\Service\ImageService;
use App\Traits\JsonResponseTrait;
use App\Transformer\ImageTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/image', name: 'add_image', methods: ['POST'])]
    public function add(Request $request, ImageService $imageService, ImageTransformer $imageTransformer): JsonResponse
    {
        $file = $request->files->get('image');
        $image = $imageService->upload($file);
        $imageResult = $imageTransformer->toArray($image);

        return $this->success($imageResult);
    }
}
