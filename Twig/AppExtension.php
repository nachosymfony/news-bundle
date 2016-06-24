<?php
namespace nacholibre\NewsBundle\Twig;

class AppExtension extends \Twig_Extension {
    public function __construct($container) {
        $this->container = $container;
    }

    public function getFunctions() {
        return [
            new \Twig_SimpleFunction('nacholibre_news_post_link', [$this, 'postLink']),
        ];
    }

    public function postLink($post) {
        $router = $this->container->get('router');

        $parameters = $this->container->getParameter('nacholibre_news');
        $type = $parameters['urls']['type'];

        switch($type) {
        case "date_prefixed":
            $url = $router->generate('nacholibre.news.show', [
                'slug' => $post->getSlug(),
                'year' => $post->getCreatedDateSlug()->format('Y'),
                'month' => $post->getCreatedDateSlug()->format('m'),
                'day' => $post->getCreatedDateSlug()->format('d'),
            ]);
            break;
        case "slug_id":
            $url = $router->generate('nacholibre.news.show', [
                'slug' => $post->getSlug(),
                'id' => $post->getID(),
            ]);
            break;
        }
        return $url;
    }

    public function getName()
    {
        return 'news_extension';
    }
}
