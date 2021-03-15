<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Image;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

//use Doctrine\ORM\Mapping\Entity;

class FigureController extends AbstractController
{


    /**
     * @Route("/add/figure", name="app_add_figure")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function add(EntityManagerInterface $manager, Request $request, FileUploader $fileUploader): Response
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Veuillez vous identifier pour ajouter une figure');
            return $this->redirectToRoute('app_homePage');
        }

        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('files')->getData();
            foreach ($files as $file) {
                $image = new Image();
                $image->setName($fileUploader->upload($file));
                $figure->addImage($image);
            }
            $manager->persist($figure);
            $manager->flush();
            return $this->redirectToRoute('app_homePage');
        }
        return $this->render('figure/addFigure.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route( "/", name="app_homePage")
     * @param FigureRepository $repository
     * @return Response
     */
    public function listFigure(FigureRepository $repository): Response
    {
        $figures = $repository->findAll();

        return $this->render('pages/homePage.html.twig', ['figures' => $figures]);
    }


}
