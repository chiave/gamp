<?php

namespace Chiave\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'ChiaveCoreBundle:Dashboard:index.html.twig'
        );
    }

}
