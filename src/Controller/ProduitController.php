<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProduitController extends AbstractController
{
    /**
     * @Route("/product/{id}", name="produit")
     */
    public function index(NormalizerInterface $normalizer,  $id, ProductRepository $productRepository, Request $request): Response
    {

        $product = $productRepository->findBy(["SubCategory" => $id]);


        if ($request->isMethod('post')) {

            if ($request->get("searchfilter")) {
                $name = $request->get("searchfilter");
                $filterProduct = $productRepository->findBy(["Name" => $name]);
            }




            return $this->render('produit/index.html.twig', array(
                'id' => $id,
                'products' => $filterProduct,
            ));
        }
        // dd($product);
        // $content = $normalizer->normalize($product, 'json', ['groups' => 'product']);

        // return new Response(json_encode($content));

        return $this->render('produit/index.html.twig', array(
            'id' => $id,
            'products' => $product,
        ));
    }

    /**
     * @Route("/filter/{id}/{price}", name="filterByPrice")
     */
    public function filter($id, $price, ProductRepository $productRepository): Response
    {

        $product = $productRepository->filter($price, $id);


        return $this->render('produit/filter.html.twig', array(
            'id' => $id,
            'products' => $product,
        ));
    }
}
