<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/add/product", name="AjoutProduit")
     */
    public function AddProduct(SubCategoryRepository $subCategoryRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $subcategories = $subCategoryRepository->findAll();


        $product = new Product();

        if ($request->isMethod("POST")) {
            $product->setName($request->get("name"));
            $product->setDescription($request->get("description"));
            $product->setImage($request->get("image"));

            $managerRegistry->getManager()->persist($product);

            $managerRegistry->getManager()->flush();
        }



        return $this->render('admin/addProduct.html.twig', [
            "subcategories" => $subcategories,
        ]);
    }


    /**
     * @Route("/admin/delete/product", name="DeleteProduct")
     */
    public function removeProduct(ProductRepository $productRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $products = $productRepository->findAll();


        if ($request->isMethod("POST")) {
            $product = $productRepository->findOneBy(["id" => $request->get("id")]);


            $managerRegistry->getManager()->remove($product);


            $managerRegistry->getManager()->flush();
        }



        return $this->render('admin/deleteProduct.html.twig', [
            "products" => $products,
        ]);
    }

    /**
     * @Route("/admin/update/product/{id}", name="UpdateProduct")
     */
    public function UpdateProduct($id, ProductRepository $productRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $product = $productRepository->findOneBy(["id" => $id]);



        if ($request->isMethod("POST")) {

            $product->setName($request->get("name"));
            $product->setDescription($request->get("description"));
            $product->setImage($request->get("image"));


            $managerRegistry->getManager()->persist($product);


            $managerRegistry->getManager()->flush();
        }



        return $this->render('admin/updateProduct.html.twig', [
            "product" => $product,
        ]);
    }
}
