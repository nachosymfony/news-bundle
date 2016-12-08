<?php

namespace nacholibre\NewsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use nacholibre\NewsBundle\Entity\Post;
use nacholibre\NewsBundle\Form\PostType;

class NewsController extends Controller {
    function __construct() {
        //$params = $this->getParameter('nacholibre_news');
        //$this->postClass = $params['post_class'];
    }
    /**
     * Lists all Post entities.
     *
     * @Route("/", name="nacholibre.news.admin.index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $params = $this->getParameter('nacholibre_news');
        $postClass = $params['entity_class'];

        $posts = $em->getRepository($postClass)->findBy([], [
            'id' => 'DESC'
        ]);

        return $this->render('nacholibreNewsBundle:Admin:index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/new", name="nacholibre.news.admin.new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $params = $this->getParameter('nacholibre_news');
        $postClass = $params['entity_class'];

        $post = new $postClass;
        $form = $this->createForm('nacholibre\NewsBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post->setUser($this->getUser());
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('nacholibre.news.admin.edit', ['id' => $post->getID()]);
        }

        return $this->render('nacholibreNewsBundle:Admin:add_edit.html.twig', array(
            'post' => $post,
            'headerTitle' => 'Add News',
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="nacholibre.news.admin.edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $params = $this->getParameter('nacholibre_news');
        $postClass = $params['entity_class'];

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($postClass);

        $post = $repo->findOneBy(['id' => $id]);

        //$deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('nacholibre\NewsBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('nacholibre.news.admin.edit', array('id' => $post->getId()));
        }

        return $this->render('nacholibreNewsBundle:Admin:add_edit.html.twig', array(
            'headerTitle' => 'Edit News',
            'form' => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/delete/{id}", name="nacholibre.news.admin.delete")
     */
    public function deleteAction($id) {
        $params = $this->getParameter('nacholibre_news');
        $postClass = $params['entity_class'];

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($postClass);

        $post = $repo->findOneBy(['id' => $id]);
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('nacholibre.news.admin.index');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $post The Post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nacholibre.news.admin.delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
