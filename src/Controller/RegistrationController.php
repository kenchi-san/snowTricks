<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{



    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setToken(
                $token = md5(time() . mt_rand())
            );
            $user->setIsVerified(0);
            $entityManager = $this->getDoctrine()->getManager();

                $entityManager->persist($user);
                $entityManager->flush();


            $email = (new TemplatedEmail())
                ->from(new Address('charon.hugo@yahoo.fr', 'snowtrick'))
                ->to($user->getEmail())
                ->subject('Veuillez confirmer votre mail')
                ->htmlTemplate('registration/confirmation_email.html.twig')
                ->context(['token' => $user->getToken()]);
            $mailer->send($email);
            $this->addFlash(
                'success',
                'Un mail de confirmation a été envoyé'
            );
            return $this->redirectToRoute("app_homePage");

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email/{token}", name="app_verify_email")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function verifyUserEmail(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $entityManager->getRepository(User::class)->findBy(['token' => $request->get('token')]);
        if (!$user) {
            throw $this->createNotFoundException('Erreur 404 : page non trouvé');
        }

        $user['0']->setIsVerified(true);
        $user['0']->setToken(null);
        $entityManager->flush();
        $this->addFlash('success', 'Votre mail a été vérifier.');

        return $this->redirectToRoute('app_login');


    }



}
