<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/bibi", name="homePage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showHome()
    {
        return $this->render('pages/homePage.html.twig');
    }

}