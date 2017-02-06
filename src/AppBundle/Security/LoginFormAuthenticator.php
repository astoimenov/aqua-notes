<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /**
     * @var Symfony\Component\Form\FormInterface
     */
    protected $form;

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * @var Symfony\Component\Routing\RouterInterface
     */
    protected $router;

    /**
     * @var Symfony\Component\Security\Core\Encoder\UserPasswordEncoder
     */
    protected $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $manager, RouterInterface $router, UserPasswordEncoder $passwordEncoder)
    {
        $this->form = $formFactory->create(LoginForm::class);
        $this->manager = $manager;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/auth/login' && $request->isMethod('POST');
        if (!$isLoginSubmit) {
            return;
        }

        $this->form->handleRequest($request);

        $data = $this->form->getData();
        $request->getSession()->set(Security::LAST_USERNAME, $data['_username']);

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->manager->getRepository(User::class)->findOneBy([
            'email' => $credentials['_username'],
        ]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->passwordEncoder->isPasswordValid($user, $credentials['_password'])) {
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('auth_login');
    }

    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }
}
