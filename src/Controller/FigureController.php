<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Entity\Image;
use App\Form\CommentType;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @IsGranted("ROLE_USER")
     */
    public function add(EntityManagerInterface $manager, Request $request, FileUploader $fileUploader)
    {
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
            $this->addFlash('success', 'la figure à bien été ajouté');

            return $this->redirectToRoute('app_homePage');
        }
        return $this->render('figure/addFigure.html.twig', ['form' => $form->createView(),]);

    }

    /**
     * @Route( "/", name="app_homePage")
     * @param FigureRepository $figureRepository
     * @return Response
     */
    public function list(FigureRepository $figureRepository): Response
    {
        $figures = $figureRepository->findAll();

        return $this->render('pages/homePage.html.twig', ['figures' => $figures]);
    }

    /**
     * @Route("/show/figure/{id}",name="app_show_figure")
     * @param Figure $figure
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(Figure $figure, Request $request, EntityManagerInterface $manager): Response
    {
        $myComment = new Comment();
        $form = $this->createForm(CommentType::class, $myComment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $myComment->setContent($myComment->getContent());
            $myComment->setUser($this->getUser());
            $figure->addComment($myComment);
            $manager->persist($figure);
            $manager->flush();
            return $this->redirectToRoute("app_show_figure", ['id' => $figure->getId()]);
        }
        return $this->render("figure/showFigure.html.twig", ['figure' => $figure, 'form' => $form->createView()]);
    }

    /**
     * @Route("/deleted/figure/{id}",name="app_deleted_figure")
     * @param Figure $figure
     * @param EntityManagerInterface $manager
     * @param FileUploader $fileUploader
     * @return RedirectResponse
     */
    public function deleted(Figure $figure,EntityManagerInterface $manager, FileUploader $fileUploader): RedirectResponse
    {

        $manager->remove($figure);
        $manager->flush();
        $fileUploader->remove($figure->getImages()->getValues());
        $this->addFlash('success', 'la figure à bien été supprimé');
        return $this->redirectToRoute("app_homePage");
    }

    /**
     * @Route("/edit/figure/{id}",name="app_edit_figure")
     * @param Figure $figure
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return RedirectResponse|Response
     */
    public function edit(Figure $figure, EntityManagerInterface $manager, Request $request, FileUploader $fileUploader)
    {
        if (!$this->getUser()) {
            $this->addFlash('danger', 'Veuillez vous identifier pour ajouter une figure');
            return $this->redirectToRoute('app_homePage');
        }
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
            $this->addFlash('success', 'la figure à bien été édité');
            return $this->redirectToRoute("app_edit_figure", ['id' => $figure->getId()]);
        }
//        return $this->redirectToRoute('app_homePage');
        return $this->render('figure/editFigure.html.twig', ['form' => $form->createView()]);

    }
}
