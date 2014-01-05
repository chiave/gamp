<?php

namespace Musicisti\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Musicisti\CMSBundle\Entity\Pages;
use Musicisti\CMSBundle\Form\PagesType;

/**
 * Pages controller.
 *
 * @Route("/pages")
 */
class PagesController extends Controller
{

    /**
     * Lists all Pages.
     *
     * @Route("/", name="cms_pages")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('MusicistiCMSBundle:Pages')
            ->findBy(array(), array('createdAt' => 'DESC'));

        return $this->render('MusicistiCMSBundle:Pages:index.html.twig', array(
            'pages' => $pages,
        ));
    }

    /**
     * Creates a new Pages.
     *
     * @Route("/", name="cms_pages_create")
     * @Method("POST")
     * @Template("MusicistiCMSBundle:Pages:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $page = new Pages();
        $form = $this->createPageForm(
            $page,
            'cms_pages_create'
            );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('cms_pages'));
        }

        return $this->render('MusicistiCMSBundle:Pages:new.html.twig', array(
            'page' => $page,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Pages.
     *
     * @Route("/new", name="cms_pages_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $page = new Pages();
        $form = $this->createPageForm(
            $page,
            'cms_pages_create'
            );

        return $this->render('MusicistiCMSBundle:Pages:new.html.twig', array(
            'page' => $page,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pages entity.
     *
     * @Route("/{id}", name="cms_pages_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('MusicistiCMSBundle:Pages')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'page'      => $page,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pages.
     *
     * @Route("/{id}/edit", name="cms_pages_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('MusicistiCMSBundle:Pages')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Pages.');
        }

        $editForm = $this->createPageForm(
            $page,
            'cms_pages_update'
            );
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MusicistiCMSBundle:Pages:edit.html.twig', array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Pages.
     *
     * @Route("/{id}", name="cms_pages_update")
     * @Method("POST")
     * @Template("MusicistiCMSBundle:Pages:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('MusicistiCMSBundle:Pages')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Pages.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createPageForm(
            $page,
            'cms_pages_update'
            );
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cms_pages_edit', array('id' => $id)));
        }

        return $this->render('MusicistiCMSBundle:Pages:edit.html.twig', array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pages.
     *
     * @Route("/{id}", name="cms_pages_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $page = $em->getRepository('MusicistiCMSBundle:Pages')->find($id);

            if (!$page) {
                throw $this->createNotFoundException('Unable to find Pages.');
            }

            $em->remove($page);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cms_pages'));
    }

    /**
    * Creates a form for page.
    *
    * @param Pages $page
    * @param string $route
    *
    * @return \Symfony\Component\Form\Form Form for page
    */
    public function createPageForm(Pages $page, $route)
    {
        return $this->createForm(
            new PagesType(),
            $page,
            array(
                'action' => $this->generateUrl(
                    $route,
                    array(
                        'id' => $page->getId(),
                    )),
                'method' => 'post',
            )
        );
    }

    /**
     * Creates a form to delete a Page by id.
     *
     * @param mixed $id The page id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cms_pages_delete', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Usuń stronę'))
            ->getForm()
        ;
    }
}
