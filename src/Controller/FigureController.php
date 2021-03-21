<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Entity\Image;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use App\Repository\ImageRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Instanceof_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param FigureRepository $figureRepository
     * @param ImageRepository $imageRepository
     * @return Response
     */
    public function list(FigureRepository $figureRepository, ImageRepository $imageRepository): Response
    {
        $figures = $figureRepository->findAll();
        $images = $imageRepository->findAll();

        return $this->render('pages/homePage.html.twig', [ 'figures'=>$figures,'images'=>$images]);
    }

    /**
     * @Route("/show/figure/{id}",name="app_show")
     * @param Figure $figure
     * @param ImageRepository $image
     * @return Response
     */
    public function show(Figure $figure, ImageRepository $image): Response
    {

        $image = $image->findOneBy(array('figure' => $figure->getId()));


        return $this->render("figure/showFigure.html.twig", ['figure' => $figure, 'images' => $image]);

    }

    /**
     * @Route("/deleted/figure/{id}",name="app_deleted")
     * @param Figure $figure
     * @param EntityManagerInterface $manager
     * @return RedirectResponse
     */
    public function deleted(Figure $figure, EntityManagerInterface $manager): RedirectResponse
    {
        $manager->remove($figure);
        $manager->flush();
        return $this->redirectToRoute("app_homePage");
    }


}
