<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function getManager()
    {
        if (!$this->manager) {
            $this->manager = $this->get('doctrine')->getManager();
        }

        return $this->manager;
    }

    public function getRepository($modelClass)
    {
        if (!$this->repository) {
            $this->repository = $this->getManager()->getRepository($modelClass);
        }

        return $this->repository;
    }
}
