<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

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

            $video->setLink($form->get('link')->getData());
            $video->setFigure($video->getFigure());
            $manager->persist($video);
            $manager->flush();
            $this->addFlash('success', 'la vidéo à bien été modifié');
            $this->redirectToRoute("app_edit_image", ['id' => $video->getId()]);
        }
        return $this->render('video/editVideo.html.twig', ['form' => $form->createView()]);
    }

}
