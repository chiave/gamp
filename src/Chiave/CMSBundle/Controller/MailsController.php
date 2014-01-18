<?php

namespace Chiave\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Chiave\CMSBundle\Entity\Mails;
use Chiave\CMSBundle\Form\MailsType;

/**
 * Pages controller.
 *
 * @Route("/")
 */
class MailsController extends Controller
{

    /**
     * Lists all mails.
     *
     * @Route("/admin/mails", name="cms_mails")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mails = $em->getRepository('ChiaveCMSBundle:Mails')
            ->findBy(array(), array('createdAt' => 'DESC'));

        return $this->render('ChiaveCMSBundle:Mails:index.html.twig', array(
            'mails' => $mails,
        ));
    }

    /**
     * Finds and displays mail.
     *
     * @Route("/admin/mails/show/{id}", name="cms_mails_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $mail = $em->getRepository('ChiaveCMSBundle:Mails')->find($id);

        if (!$mail) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return array(
            'mail'      => $mail,
        );
    }

    /**
     * Render contact forms.
     *
     * @Route("/mails/renderForm/{type}", name="cms_mails_renderForm")
     * @Method("GET")
     * @Template()
     */
    public function renderFormAction($type = 'contact')
    {
        $mail = new Mails();

        $form = $this->createForm(
            new MailsType($type),
            $mail,
            array(
                'action' => $this->generateUrl("cms_mails_persist"),
                'method' => 'post',
            )
        );

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a new Mail.
     *
     * @Route("/mails/persistForm/{type}", name="cms_mails_persist")
     * @Method("POST")
     * @Template("ChiaveCMSBundle:Mails:renderForms.html.twig")
     */
    public function persistAction(Request $request, $type = 'contact')
    {
        $result = new \stdClass();
        $result->success = false;

        $mail = new Mails();

        $form = $this->createForm(
            new MailsType($type),
            $mail,
            array(
                'action' => $this->generateUrl("cms_mails_persist"),
                'method' => 'post',
            )
        );

        $form->handleRequest($request);

        $data = $form->getData();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mail);
            $em->flush();

            $result->success = true;
            return new JsonResponse(
                    $result
            );
        }

        return new JsonResponse(
                $result
        );
    }
}
