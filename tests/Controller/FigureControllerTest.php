<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FigureControllerTest extends WebTestCase
{


    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url, $expectedStatus = 200)
    {

        $client = self::createClient();
        $userRepository = $client->getContainer()->get(UserRepository::class);
        $client->loginUser($userRepository->find(1));

        $client->request('GET', $url);
        $this->assertResponseStatusCodeSame($expectedStatus);
    }

    public function urlProvider()
    {
        yield "homepage" => ['/'];

        yield "figure create" => ['/add/figure'];
        yield "figure show" => ['/show/figure/1/ma-figure-n01'];
        yield "figure delete" => ['/deleted/figure/1', 302];
        yield "figure edit" => ['/edit/figure/1'];
//        yield "comment edit" => ['/edit/comment/1',302];
//        yield "1" => ['/deleted/comment/1'];
        yield "2" => ['/edit/image/1'];
        yield "3" => ['/delete/image/1',302];
//        yield "3" => ['/verify/email/{token}'];
        yield "" => ['/login',302];
//        yield "" => ['/reset_your_password'];
//        yield "" => ['/new_password/auth/{token}'];
//        yield "" => [''];
//        yield "" => ['/register'];
//        yield "" => ['/register'];
//        yield "" => ['/register'];
//        yield "" => ['/register'];
    }

}