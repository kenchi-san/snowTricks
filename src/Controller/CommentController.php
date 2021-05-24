<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    /**
     * @Route("/edit/comment/{id}",name="app_edit_comment")
     * @param Comment $comment
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * @IsGranted("COMMENT_EDIT", subject="comment")
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('success', 'le commentaire à bien été modifié');
            return $this->redirectToRoute("app_show_figure", ['id' => $comment->getFigure()->getId()]);
        }
            return $this->render("comment/edit.html.twig", ['comment' => $comment, 'form' => $form->createView()]);
    }

    /**
     * @Route("/deleted/comment/{id}",name="app_deleted_comment")
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @IsGranted("COMMENT_DELETE", subject="comment")
     */
    public function deleted(Comment $comment, EntityManagerInterface $manager): Response
    {
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash('success', 'commentaire supprimé');
        return $this->redirectToRoute("app_show_figure", ['id' => $comment->getFigure()->getId()]);

    }
}