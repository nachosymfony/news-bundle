<?php

namespace nacholibre\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

#use nacholibre\NewsBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
    * @Route("/{page}", name="nacholibre.news.index", defaults={"page" = 1})
    */
    public function indexAction($page, Request $request) {
        $newsManager = $this->get('nacholibre.news.manager');
        $repo = $newsManager->getRepo();

        $em = $this->getDoctrine()->getManager();

        //$news = $repo->findBy([], [
        //    'id' => 'DESC',
        //]);
        $perPage = 10;

        $qb = $em->createQueryBuilder('p');
        $qb->select('p')
            ->from($newsManager->getClassName(), 'p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($perPage)
            ;

        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        $query->setHint(\Gedmo\Translatable\TranslatableListener::HINT_INNER_JOIN, true);
        //$query->setHint(
        //    \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
        //    0 // fallback to default values in case if record is not translated
        //);

        $news = $query->getResult();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $perPage/*limit per page*/
        );

        return $this->render('nacholibreNewsBundle:Default:index.html.twig', [
            'news' => $pagination,
        ]);
    }

    public function recentPostsAction($max=6) {
        $newsManager = $this->get('nacholibre.news.manager');
        $repo = $newsManager->getRepo();

        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder('p');
        $qb->select('p')
            ->from($newsManager->getClassName(), 'p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($max)
            ;

        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );
        $query->setHint(\Gedmo\Translatable\TranslatableListener::HINT_INNER_JOIN, true);

        $posts = $query->getResult();

        //$posts = $repo->findBy([], [
        //    'id' => 'DESC',
        //], $max);

        return $this->render('nacholibreNewsBundle:Default:_recentPosts.html.twig', [
            'posts' => $posts,
        ]);
    }

    public function datePrefixedAction($year, $month, $day, $slug, Request $request) {
        $dateSlug = sprintf('%s-%s-%s', $year, $month, $day);

        $newsManager = $this->get('nacholibre.news.manager');

        $em = $this->getDoctrine()->getManager();
        $repo = $newsManager->getRepo();

        $qb = $em->createQueryBuilder('p');
        $qb->select('p')
            ->from($newsManager->getClassName(), 'p')
            ->andWhere('p.createdDateSlug = :dateSlug')
            ->andWhere('p.slug = :slug')
            ->setParameter('dateSlug', new \Datetime($dateSlug))
            ->setParameter('slug', $slug)
            ;

        $query = $qb->getQuery();
        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $post = $query->getResult();
        if(is_array($post) && $post) {
            $post = $post[0];
        }

        //$post = $repo->findOneBy(
        //    [
        //        'createdDateSlug' => new \Datetime($dateSlug),
        //        'slug' => $slug,
        //    ]
        //)->setHint(
        //    \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
        //    'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        //);

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

    public function slugAction($slug, $request) {
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
