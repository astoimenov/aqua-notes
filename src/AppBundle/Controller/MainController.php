<?php

namespace AppBundle\Controller;

class MainController extends BaseController
{
    public function homepageAction()
    {
        return $this->render('main/homepage.html.twig');
    }
}
