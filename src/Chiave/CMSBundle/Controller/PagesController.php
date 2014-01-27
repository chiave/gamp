<?php

namespace Chiave\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Chiave\CMSBundle\Entity\Pages;
use Chiave\CMSBundle\Form\PagesType;

/**
 * Pages controller.
 *
 * @Route("/")
 */
class PagesController extends Controller
{

    /**
     * Lists all pages.
     *
     * @Route("/admin/pages", name="cms_pages")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('ChiaveCMSBundle:Pages')
            ->findBy(array(), array('createdAt' => 'DESC'));

        return $this->render('ChiaveCMSBundle:Pages:index.html.twig', array(
            'pages' => $pages,
        ));
    }

    /**
     * Creates new page.
     *
     * @Route("/admin/pages/create", name="cms_pages_create")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template("ChiaveCMSBundle:Pages:new.html.twig")
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

        return $this->render('ChiaveCMSBundle:Pages:new.html.twig', array(
            'page' => $page,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create new page.
     *
     * @Route("/admin/pages/new", name="cms_pages_new")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function newAction()
    {
        $page = new Pages();
        $form = $this->createPageForm(
            $page,
            'cms_pages_create'
            );

        return $this->render('ChiaveCMSBundle:Pages:new.html.twig', array(
            'page' => $page,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays page.
     *
     * @Route("/{slug}", name="cms_pages_show", defaults={"slug" = ""})
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('ChiaveCMSBundle:Pages')->findOneBySlug($slug);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return array(
            'page'      => $page,
        );
    }

    /**
     * Displays a form to edit an existing page.
     *
     * @Route("/admin/pages/{id}/edit", name="cms_pages_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('ChiaveCMSBundle:Pages')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Pages.');
        }

        $editForm = $this->createPageForm(
            $page,
            'cms_pages_update'
            );
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ChiaveCMSBundle:Pages:edit.html.twig', array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing page.
     *
     * @Route("/admin/pages/{id}/update", name="cms_pages_update")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template("ChiaveCMSBundle:Pages:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('ChiaveCMSBundle:Pages')->find($id);

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

        return $this->render('ChiaveCMSBundle:Pages:edit.html.twig', array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes page.
     *
     * @Route("/admin/pages/{id}/delete", name="cms_pages_delete")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $page = $em->getRepository('ChiaveCMSBundle:Pages')->find($id);

            if (!$page) {
                throw $this->createNotFoundException('Unable to find Pages.');
            }

            $em->remove($page);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cms_pages'));
    }

    /**
     * Render main page boxes.
     *
     * @Route("/renderMenu", name="cms_pages_menu")
     * @Method("GET")
     * @Template()
     */
    public function renderMenuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('ChiaveCMSBundle:Pages')
            ->findBy(
                array('inMenu' => true),
                array('position' => 'ASC')
        );

        return array(
            'pages' => $pages,
        );
    }

    /**
     * Render main page boxes.
     *
     * @Route("/", name="cms_pages_main")
     * @Method("GET")
     * @Template()
     */
    public function renderMainPageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('ChiaveCMSBundle:Pages')
            ->findBy(array(), array('position' => 'ASC'));

        return array(
            'pages' => $pages,
        );
    }

    /**
     * Render download page.
     *
     * @Route("/", name="cms_pages_download")
     * @Method("GET")
     * @Template()
     */
    public function renderDownloadPageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = array();

        $files = $em->getRepository('ChiaveCMSBundle:Files')
            ->findBy(
                array(
                   'type' => array(1, 2, 3),
                   'visible' => true
                )
             );

        foreach ($files as $file) {
            $categories[$file->getTypeText()][] = $file;
        }

        return array(
            'categories' => $categories,
        );
    }

    /**
     * Render gallery page.
     *
     * @Route("/", name="cms_pages_gallery")
     * @Method("GET")
     * @Template()
     */
    public function renderGalleryPageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('ChiaveCMSBundle:Files')
            ->findBy(
                array(
                   'type' => 4,
                   'visible' => true
                )
             );

        return array(
            'images' => $images,
        );
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
     * Creates a form to delete page.
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
