<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $tableProduct): Response
    {
        // $products = $tableProduct->findAll();
        // dump($products);
        // dd($products) for dump & die
        return $this->render('product/index.html.twig', [
            'products' => $tableProduct->findAll(),
        ]);
    }

    // #[Route('/product/{id<\d+>}')]
    // public function show($id, ProductRepository $tableProduct): Response {
    //    $product = $tableProduct->findOneBy(['id' => $id]); // find($id) for ids
    //     if ($product === null) {
    //         throw $this->createNotFoundException('Product not found'); 
    //     }
    //     return $this->render('product/show.html.twig', [
    //     'product' => $product,
    //    ]);
    // }

    // same but faster
    #[Route('/product/{id<\d+>}', name: 'app_product_show')]
    public function show(Product $product): Response {
        return $this->render('product/show.html.twig', [
        'product' => $product,
       ]);
    }

}
