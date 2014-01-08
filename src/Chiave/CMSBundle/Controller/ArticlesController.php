<?php

namespace Chiave\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Chiave\CMSBundle\Entity\Articles;
use Chiave\CMSBundle\Form\ArticlesType;

/**
 * Articles controller.
 *
 * @Route("/")
 */
class ArticlesController extends Controller
{

    /**
     * Lists all Articles.
     *
     * @Route("/admin/articles", name="cms_articles")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')"
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('ChiaveCMSBundle:Articles')
            ->findBy(array(), array('createdAt' => 'DESC'));

        return array(
            'articles' => $articles,
        );
    }

    /**
     * Creates a new Articles.
     *
     * @Route("/admin/articles/create", name="cms_articles_create")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')"
     * @Template("ChiaveCMSBundle:Articles:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $article = new Articles();
        $form = $this->createArticleForm(
            $article,
            'cms_articles_create'
            );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('cms_articles'));
        }

        return array(
            'article' => $article,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Articles.
     *
     * @Route("/admin/articles/new", name="cms_articles_new")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')"
     * @Template()
     */
    public function newAction()
    {
        $article = new Articles();
        $form = $this->createArticleForm(
            $article,
            'cms_articles_create'
            );

        return array(
            'article' => $article,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Articles.
     *
     * @Route("/articles/{id}", name="cms_articles_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ChiaveCMSBundle:Articles')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Articles.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'article'      => $article,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Articles.
     *
     * @Route("/admin/articles/{id}/edit", name="cms_articles_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')"
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ChiaveCMSBundle:Articles')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Articles article.');
        }

        $editForm = $this->createArticleForm(
            $article,
            'cms_articles_update'
            );
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'article'      => $article,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Articles.
     *
     * @Route("/admin/articles/{id}/update", name="cms_articles_update")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')"
     * @Template("ChiaveCMSBundle:Articles:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ChiaveCMSBundle:Articles')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Articles article.');
        }

        $deleteForm = $this->createDeleteForm($id);

        $editForm = $this->createArticleForm(
            $article,
            'cms_articles_update'
            );
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cms_articles_edit', array('id' => $id)));
        }

        return array(
            'article'      => $article,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Articles.
     *
     * @Route("/admin/articles/{id}/delete", name="cms_articles_delete")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')"
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article = $em->getRepository('ChiaveCMSBundle:Articles')->find($id);

            if (!$article) {
                throw $this->createNotFoundException('Unable to find Articles.');
            }

            $em->remove($article);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cms_articles'));
    }

    /**
    * Creates a form for article.
    *
    * @param Articles $article
    * @param string $route
    *
    * @return \Symfony\Component\Form\Form Form for page
    */
    public function createArticleForm(Articles $article, $route)
    {
        return $this->createForm(
            new ArticlesType(),
            $article,
            array(
                'action' => $this->generateUrl(
                    $route,
                    array(
                        'id' => $article->getId(),
                    )),
                'method' => 'post',
            )
        );
    }

    /**
     * Creates a form to delete a Articles by id.
     *
     * @param mixed $id The article id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cms_articles_delete', array('id' => $id)))
            ->setMethod('POST')
            ->add('submit', 'submit', array('label' => 'Usuń artykuł'))
            ->getForm()
        ;
    }
}
