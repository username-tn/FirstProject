<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\ProductType;
use App\Form\SubCategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SubCategoryRepository;
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
     * @Route("DeletesubCategory/{id}/",name="delete_sub_category")
     */

    public function DeleteSubCategory($id, SubCategoryRepository $repository)
    {
        $em = $this->getDoctrine()->getManager();
        $subcat = $repository->find($id);
        $em->remove($subcat);
        $em->flush();
        return $this->redirectToRoute('shop');
    }
    /**
     * @Route("/subcategory/update/{id}", name="UpdateSubCategory")
     */
    public function updateSubCategory(Request $request, CategoryRepository $categoryRepository, $id, SubCategoryRepository $subCategoryRepository)
    {
        $categories = $categoryRepository->findAll();
        $subcategory = $subCategoryRepository->findOneBy(["id" => $id]);
        $success = false;

        if ($request->isMethod("POST")) {
            $category = $categoryRepository->findOneBy(["id" => $request->get("category")]);


            $subcategory->setName($request->get("name"));
            $subcategory->setDescription($request->get("description"));
            $subcategory->setCategory($category);


            $uploadedFile = $request->files->get("image");
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );

                $subcategory->setImage($newFilename);
            }






            $em = $this->getDoctrine()->getManager();
            $em->persist($subcategory);
            $em->flush();
            $success = true;
        }


        return $this->render('subcategory/UpdateSubCategory.html.twig', [
            "categories" => $categories,
            "SubCategory" => $subcategory,
            "Success" => $success,
        ]);
    }


    /**
     * @Route("/ajout_sub_category",name="ajout_sub_category")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @return Response
     */
    public function ajout_sub_category(Request $request, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $success = false;

        if ($request->isMethod("POST")) {
            $subCategory = new SubCategory();
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->files->get("image");
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $subCategory->setImage($newFilename);
            }
            $category = $categoryRepository->findOneBy(["id" => $request->get("category")]);

            $subCategory->setDescription($request->get("description"));
            $subCategory->setName($request->get("name"));
            $subCategory->setCategory($category);


            $em = $this->getDoctrine()->getManager();

            $em->persist($subCategory);
            $em->flush();
            $success = true;
        }


        return $this->render('subcategory/AddNewSubCategory.html.twig', [
            "Success" => $success,
            "categories" => $categories,
        ]);
    }
}
