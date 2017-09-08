<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function getRepo($entity)
    {
        return $this->getDoctrine()->getRepository($entity);
    }
}
