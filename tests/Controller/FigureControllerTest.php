<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FigureControllerTest extends WebTestCase
{


    /**
     * @dataProvider urlProvider
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
     * @dataProvider urlProviderTest
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
        $client = self::createClient();
        $userRepository = $client->getContainer()->get(UserRepository::class);
        $client->loginUser($userRepository->findOneBy(['userName' => 'user0']));
        $crawler = $client->request('GET', '/add/figure');
        $buttonCrawlerNode = $crawler->selectButton('Valider');
        $form = $buttonCrawlerNode->form();
        $form['figure[name]'] = "figure numéro 1";
        $form['figure[content]'] = "contenu balbablablalbalbalb";
        $form['figure[category]']->select("1");
        $form['figure[files][0]']->upload("picture1.png");
        $client->submit($form);

        $client->followRedirect();
        $this->assertResponseIsSuccessful( $message = 'la figure à bien été ajouté');

    }
}

