<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Image;
use App\Form\ImageType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{


    /**
     * @Route("/edit/image/{id}",name="app_edit_image")
     * @param Image $image
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function edit(Image $image, Request $request, EntityManagerInterface $manager, FileUploader $fileUploader): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Veuillez vous identifier pour éditer l\'image');
            return $this->redirectToRoute("app_login");
        }
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $fileUploader->remove(['image' => $image->getName()]);

            $file = $form->get('file')->getData();
            $image->setName($fileUploader->upload($file));
            $image->setFigure($image->getFigure());
            $manager->persist($image);

            $manager->flush();
            $this->addFlash('success', 'image éditée avec succès');
            return $this->redirectToRoute("app_edit_image", ['id' => $image->getId()]);
        }
        return $this->render('image/editImage.html.twig', ['image' => $image, 'form' => $form->createView()]);
    }

    /**
     * @Route("/delete/image/{id}")
     * @param Image $image
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function deleted(Image $image, FileUploader $fileUploader, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Veuillez vous identifier pour supprimer l\'image');
            return $this->redirectToRoute("app_login");
        }

if (count($manager->getRepository(Image::class)->findBy(['figure'=>$image->getFigure()])) <= 1) {
    $this->addFlash('warning', "Impossible de supprimer l'image");
    return $this->redirectToRoute('app_edit_figure', ['id' => $image->getFigure()->getId()]);
}
        $manager->remove($image);
        $manager->flush();
        $fileUploader->remove(['image' => $image->getName()]);
        $this->addFlash('success', 'l\'image à bien été supprimé');
        return $this->redirectToRoute("app_homePage");
    }
}
