<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $tableProduct): Response
    {
        // $products = $tableProduct->findAll();
        // dump($products);
        // dd($products) pour dump & die
        return $this->render('product/index.html.twig', [
            'products' => $tableProduct->findAll(),
        ]);
    }
}
