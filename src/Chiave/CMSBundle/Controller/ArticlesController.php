<?php

namespace Chiave\CMSBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Doctrine\Common\Collections\ArrayCollection;

use Chiave\CMSBundle\Entity\Pages;
use Chiave\CMSBundle\Entity\Articles;
use Chiave\CMSBundle\Entity\Entries;

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
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Template("ChiaveCMSBundle:Pages:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ChiaveCMSBundle:Articles')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Articles.');
        }

        $page = clone $article->getPage();
        foreach ($page->getArticles() as $wrongArticle) {
            $page->removeArticle($wrongArticle);
        }
        $page->addArticle($article);

        return array(
            'page'      => $page,
        );
    }

    /**
     * Displays a form to edit an existing Articles.
     *
     * @Route("/admin/articles/{id}/edit", name="cms_articles_edit")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
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

        return array(
            'article'      => $article,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Articles.
     *
     * @Route("/admin/articles/{id}/update", name="cms_articles_update")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     * @Template("ChiaveCMSBundle:Articles:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ChiaveCMSBundle:Articles')->find($id);

        if (!$article) {
            throw $this->createNotFoundException('Unable to find Articles article.');
        }

        $originalEntries = new ArrayCollection();

        foreach ($article->getEntries() as $entry) {
            $originalEntries->add($entry);
        }

        $editForm = $this->createArticleForm(
            $article,
            'cms_articles_update'
            );
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            foreach ($originalEntries as $entry) {
                if ($article->getEntries()->contains($entry)  === false) {
                    $em->remove($entry);
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('cms_articles_edit', array('id' => $id)));
        }

        return array(
            'article'      => $article,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Articles.
     *
     * @Route("/admin/articles/{id}/delete", name="cms_articles_delete")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $result = new \stdClass();
        $result->success = false;

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('ChiaveCMSBundle:Articles')->find($id);

        if (!$article) {
            // throw $this->createNotFoundException('Unable to find Articles.');
            $result->error = 'Unable to find Articles.';
        } else {
            $em->remove($article);
            $em->flush();

            $result->success = true;
        }

        return new JsonResponse($result);
    }

    // /**
    //  * Action for parent choosing based on current value of "type" field.
    //  *
    //  * @Route("/admin/articles/types/{type}", name="cms_articles_types")
    //  * @Method("POST")
    //  * @Security("has_role('ROLE_ADMIN')")
    //  */
    // public function articlesByTypeAction(Request $request, $type)
    // {
    //     $result = new \stdClass();
    //     $result->success = false;

    //     $result->articles = array();
    //     //if ($type != 0) { // TODO: insert TYPE_REGULAR contant here
    //         $articlesByType = $this->getDoctrine()
    //             ->getManager()
    //             ->getRepository('ChiaveCMSBundle:Articles')
    //             ->findBy(
    //                 array(
    //                     'type' => $type,
    //                     'parent' => null,
    //                 ),
    //                 array('header' => 'ASC')
    //             );

    //         foreach ($articlesByType as $article) {
    //             $result->articles[$article->getId()] = $article->getHeader();
    //         }
    //     //}

    //     $result->success = true;
    //     return new JsonResponse(
    //             $result
    //             );
    // }

    /**
     * Get latest n important articles.
     *
     * @Route("/admin/articles/important/{amount}", name="cms_articles_important")
     * @Method("GET")
     * @Template()
     */
    public function importantArticlesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $importantArticles = $em->getRepository('ChiaveCMSBundle:Articles')
            ->findBy(
                     array('important' => true),
                     array('createdAt' => 'DESC')
             );

        return array(
            'importantArticles' => $importantArticles,
        );
    }

    /**
    * Creates a form for article.
    *
    * @param Articles $article
    * @param string $route
    *
    * @return \Symfony\Component\Form\Form Form for page
    */
    private function createArticleForm(Articles $article, $route)
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
}
