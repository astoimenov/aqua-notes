<?php

namespace AppBundle\Controller;

use AppBundle\Form\LoginForm;
use AppBundle\Form\RegistrationForm;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/auth")
 */
class AuthController extends BaseController
{
    /**
     * @Route("/register", name="auth_register")
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(RegistrationForm::class);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user = $form->getData();

            $manager = $this->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Welcome '.$user->getEmail());

            $authenticator = $this->get('app.security.login_form_authenticator');
            $firewall = 'main';

            return $this->get('security.authentication.guard_handler')
                ->authenticateUserAndHandleSuccess($user, $request, $authenticator, $firewall);
        }

        return $this->render('AppBundle:Auth:register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="auth_login")
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render('AppBundle:Auth:login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="auth_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should not be reached!', 1);
    }
}
