<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{

    /**
     * @Route("edit/video/{id}",name="app_edit_video")
     * @param Video $video
     * @return Response
     */
    public function edit(Video $video, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($video);
            $manager->flush();
            $this->addFlash('success', 'la vidéo à bien été modifié');
            return $this->redirectToRoute("app_edit_video", ['id' => $video->getId()]);
        }
        return $this->render('video/editVideo.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("deleted/video/{id}",name="app_deleted_video")
     * @param Video $video
     * @param EntityManagerInterface $manager
     */
    public function deleted(Video $video, EntityManagerInterface $manager): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $manager->remove($video);
        $manager->flush();
        return $this->redirectToRoute('app_homePage');
    }
}
