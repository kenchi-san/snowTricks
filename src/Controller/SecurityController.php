<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Form\NewPasswordType;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Vous êtes déjà connecté');
            return $this->redirectToRoute('app_homePage');
        }
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginFormType::class, ['email' => $lastUsername]);

        return $this->render('security/login.html.twig', [
                'form' => $form->createView(),
                'last_username' => $lastUsername,
                'error' => $error ? $error->getMessage() : null]
        );
    }


    /**
     * @Route("/reset_your_password",name="app_reset_password")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param MailerInterface $mailer
     * @return Response|void
     * @throws TransportExceptionInterface
     */
    public function initResetPassword(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $user = new User();
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $form->get('email')->getData()]);

            if (!$user) {
                $this->addFlash('danger', 'Compte non trouvé');
                return $this->redirectToRoute('app_reset_password');
            }

            $user->setToken(md5(time() . mt_rand()));
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();
            $email = (new TemplatedEmail())
                ->from(new Address('charon.hugo@yahoo.fr', 'snowtrick'))
                ->to($user->getEmail())
                ->subject('Veuillez confirmer votre mail')
                ->htmlTemplate('Security/reset_password_email.html.twig')
                ->context(['token' => $user->getToken()]);
            $mailer->send($email);
            $this->addFlash(
                'success',
                'Un mail pour changer votre mot de passe a été envoyé'
            );
            return $this->redirectToRoute("app_homePage");
        }
        return $this->render('security/sendMailNewPassword.html.twig', [
            'mailForNewForm' => $form->createView(),
        ]);

    }

    /**
     * @Route("/new_password/auth/{token}",name="app_new_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function setupNewPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(NewPasswordType::class, $user);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['token' => $request->get('token')]);

        if (!$user) {
            $this->addFlash('danger', 'Utilisateur non trouvé');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            $user->setToken(null);
            $entityManager->flush();
            $this->addFlash('success', 'le mot de passe a bien été modifier ');
            return $this->redirectToRoute('app_homePage');

        }


        return $this->render('security/setupNewPasswordFromLink.html.twig', [
            'newSetupPasswordForm' => $form->createView(),
        ]);

    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


}
