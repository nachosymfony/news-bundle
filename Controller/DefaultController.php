<?php

namespace nacholibre\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('nacholibreNewsBundle:Default:index.html.twig');
    }
}
