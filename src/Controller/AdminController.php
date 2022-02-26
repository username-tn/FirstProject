<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\ProductType;
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
     * @Route("/ajout_produit",name="ajout_produit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @return Response
     */
    public function ajout_produit(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $product->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('shop');
        }
        return $this->render('test/ajout.html.twig', ['form' => $form->createView()]);
    }



    /**
     * @Route ("product/Update{id}",name="Updateproduct")
     */
    function Update_Product(ProductRepository $repository, $id, Request $request)
    {

        $produit = $repository->find($id);
        $form = $this->createForm(ProductType::class, $produit);
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $produit->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('front');
        }
        return $this->render('test/modif.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("Deleteproduct/{id}/",name="delete_product")
     */

    public function DeleteProduct($id, ProductRepository $repository)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $repository->find($id);
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('shop');
    }



    /**
     * @Route("/ajout_sub_category",name="ajout_sub_category")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @return Response
     */
    public function ajout_sub_category(Request $request): Response
    {
        $sub_category = new SubCategory();
        $form = $this->createForm(ProductType::class, $sub_category);
        $form->add('save', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $sub_category->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();

            $em->persist($sub_category);
            $em->flush();
            return $this->redirectToRoute('shop');
        }
        return $this->render('test/ajout.html.twig', ['form' => $form->createView()]);
    }
}
