<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/product/new', name: 'app_product_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($product);
            $manager->flush();
            $this->addFlash(
                'notice',
                'Product created successfully'
            );
            return $this->redirectToRoute('app_product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/product/{id<\d+>}/edit', name: 'app_product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager) {
       
        $form = $this->createForm(ProductType::class, $product);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->flush();
            $this->addFlash(
                'notice',
                'Product updated successfully'
            );
            return $this->redirectToRoute('app_product_show', ['id' => $product->getId()]);
        }
        return $this->render('product/edit.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/product/{id<\d+>}/delete', name: 'app_product_delete')]
    public function delete(Product $product, Request $request, EntityManagerInterface $manager) {
        if($request->isMethod('POST')){

            $manager->remove($product);
            $manager->flush();   
            $this->addFlash(
                'notice',
                'Product deleted successfully'
            );        
            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/delete.html.twig', [
            'product' => $product,
            'id' => $product->getId()
        ]);
    }
}
