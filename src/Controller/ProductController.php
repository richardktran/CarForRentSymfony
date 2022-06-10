<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/create", name="create_product")
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');
        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }

    /**
     * @Route("/product/validate", name="validate_product")
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function validationProduct(ValidatorInterface $validator): Response
    {
        $product = new Product();
        $product->setName(null);
        $product->setPrice('1999');

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return new Response((string)$errors, Response::HTTP_BAD_REQUEST);
        }
        return new Response("Success", Response::HTTP_OK);
    }

    /**
     * @Route("product/list", name="product_list")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function list(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAllGreaterThanPrice(100);

        return $this->render('products/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_show")
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        return new Response('Check out this great product: ' . $product->getName());
    }

    /**
     * @Route("/product/edit/{id}", name="product_update")
     */
    public function update(ManagerRegistry $doctrine, Product $product): Response
    {
        $entityManager = $doctrine->getManager();

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }
}
