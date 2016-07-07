<?php

namespace nacholibre\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

#use nacholibre\NewsBundle\Entity\Post;

class DefaultController extends Controller
{
    public function datePrefixedAction($year, $month, $day, $slug)
    {
        $dateSlug = sprintf('%s-%s-%s', $year, $month, $day);

        $newsManager = $this->get('nacholibre.news.manager');

        $em = $this->getDoctrine()->getManager();
        $repo = $newsManager->getRepo();

        $post = $repo->findOneBy(
            [
                'createdDateSlug' => new \Datetime($dateSlug),
                'slug' => $slug,
            ]
        );

        return $this->renderShowPage($post);
    }

    public function slugIDAction($slug, $id) {
        $newsManager = $this->get('nacholibre.news.manager');
        $repo = $newsManager->getRepo();

        $post = $repo->findOneBy(
            [
                'slug' => $slug,
                'id' => $id,
            ]
        );

        return $this->renderShowPage($post);
    }

    public function slugAction($slug) {
        $newsManager = $this->get('nacholibre.news.manager');
        $repo = $newsManager->getRepo();

        $post = $repo->findOneBy(
            [
                'slug' => $slug,
            ]
        );

        return $this->renderShowPage($post);
    }

    private function renderShowPage($post) {
        if (!$post) {
            throw $this->createNotFoundException('Post not found!');
        }

        $newsManager = $this->get('nacholibre.news.manager');

        $latest = $newsManager->getLatestActiveNews();

        return $this->render('nacholibreNewsBundle:Default:show.html.twig', [
            'post' => $post,
            'latest' => $latest,
        ]);
    }
}
