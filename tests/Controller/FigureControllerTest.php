<?php

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Entity\Figure;
use App\Entity\Image;
use App\Entity\Video;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FigureControllerTest extends WebTestCase
{


    /**
     * @dataFigureProvider urlProvider
     */
    public function testPageIsSuccessfulWhenConnected($url, $expectedStatus)
    {

        $client = self::createClient();
        $userRepository = $client->getContainer()->get(UserRepository::class);
        $client->loginUser($userRepository->findOneBy(['userName' => 'user0']));

        $client->request('GET', $url);
        $this->assertResponseStatusCodeSame($expectedStatus);
    }

    public function urlProvider()
    {
        yield "homepage" => ['/', 200];
        yield "figure create" => ['/add/figure', 200];
        yield "figure show" => ['/show/figure/1/ma-figure-n01', 200];
        yield "figure delete" => ['/deleted/figure/1', 302];
        yield "figure edit" => ['/edit/figure/1', 200];
        yield "comment edit" => ['/edit/comment/1', 200];
        yield "login" => ['/login', 302];
        yield "comment delete" => ['/deleted/comment/1', 302];
        yield "image edit" => ['/edit/image/1', 200];
        yield "image delete" => ['/delete/image/1', 302];
        yield "mail de verification" => ['/verify/email/{token}', 404];
        yield "reset password" => ['/reset_your_password', 200];
        yield "new password" => ['/new_password/auth/{token}', 200];

    }

    /**
     * @dataFigureProvider urlProviderTest
     */
    public function testPageIsSuccessfulWhenNoConnected($url, $expectedStatus, $expectedRedirect = null)
    {

        $client = self::createClient();


        $client->request('GET', $url);

        $this->assertResponseStatusCodeSame($expectedStatus);

        if ($expectedRedirect) {
            $this->assertResponseRedirects($expectedRedirect);
        }
    }

    public function urlProviderTest()
    {
        yield "homepage" => ['/', 200];
        yield "figure create" => ['/add/figure', 302, "/login"];
        yield "figure show" => ['/show/figure/1/ma-figure-n01', 200];
        yield "figure delete" => ['/deleted/figure/1', 302, "/login"];
        yield "figure edit" => ['/edit/figure/1', 302, "/login"];
        yield "comment edit" => ['/edit/comment/1', 302, "/login"];
        yield "login" => ['/login', 200];
        yield "comment delete" => ['/deleted/comment/1', 302, "/login"];
        yield "image edit" => ['/edit/image/1', 302, "/login"];
        yield "image delete" => ['/delete/image/1', 302, "/login"];
        yield "mail de verification" => ['/verify/email/{token}', 404];
        yield "reset password" => ['/reset_your_password', 200];
        yield "new password" => ['/new_password/auth/{token}', 200];

    }


    public function testaddFigureWhenConnected()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/add/figure');
        $buttonCrawlerNode = $crawler->selectButton('valider');
        $form = $buttonCrawlerNode->form();
        $form['figure[name]'] = "figure numéro 1";
        $form['figure[content]'] = "contenu balbablablalbalbalb";
        $form['figure[category]']->select("rotation");
        $form['figure[files][0]']->upload("picture1.png");
        $form['figure[files][1]']->upload("picture2.png");
        $form['figure[videos][1][link]']="https://www.youtube.com/embed/Gpbzcjwek_c";
        $form['figure[videos][2][link]']="https://www.youtube.com/embed/Gpbzcjwek_c";
        $client->submit($form);

       $this->assertResponseIsSuccessful( $message = 'la figure à bien été ajouté');

//        $crawler = $client->submitForm('valider');
//        $figure = new Figure();
//        $category = new Category();
//        $link = new Video();
//        $figure->setContent($figureContent);
//        $figure->setCreatedAt(new \DateTime());
//        $figure->setName($figureName);
//        $figure->setCategory($category);
//        $figure->addVideo($link);
//
//        $category->setName($categoryName);
//        $category->addFigure($figure);
//
//        $link->setFigure($figure);
//        $link->setLink($video);
    }


//    public function dataFigureProvider()
//    {
//        yield "figure" => ["figure numéro 1", "contenu balbablablalbalbalb", "rotation","picture1.png","picture2.png", "https://www.youtube.com/embed/Gpbzcjwek_c", "https://www.youtube.com/embed/Gpbzcjwek_c"];
//
//    }
}

