<?php

namespace Musicisti\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MusicistiCMSBundle:Default:index.html.twig', array('name' => $name));
    }
}
