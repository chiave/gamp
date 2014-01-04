<?php

namespace Musicisti\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'MusicistiCoreBundle:Dashboard:index.html.twig'
        );
    }

}
