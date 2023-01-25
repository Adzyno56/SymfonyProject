<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class DefaultController extends AbstractController
{
    //private ManagerRegistry $doctrine;
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $entityManager = $this->doctrine->getManager();
        $productList = $entityManager->getRepository(Product::class)->findAll();
        dd($productList);

        return $this->render('main/default/index.html.twig', []);
    }

    /**
     * @Route("/product-add", name="product_add")
     */
    public function productAdd(): Response
    {
        $product = new Product();
        $product->setTitle('product_'.rand(1,100));
        $product->setDescription('smth');
        $product->setPrice(10);
        $product->setQuantity(1);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return $this->redirectToRoute('homepage');
    }
}
