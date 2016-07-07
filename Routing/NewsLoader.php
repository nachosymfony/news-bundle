<?php
namespace nacholibre\NewsBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class NewsLoader extends Loader {
    private $loaded = false;

    public function __construct($container) {
        $this->container = $container;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();

        $parameters = $this->container->getParameter('nacholibre_news');
        $type = $parameters['urls']['type'];
        $prefix = $parameters['urls']['prefix'];

        switch($type) {
        case "date_prefixed":
            $path = $prefix . '/{year}/{month}/{day}/{slug}/';
            $defaults = array(
                '_controller' => 'nacholibreNewsBundle:Default:datePrefixed',
            );
            $requirements = array(
                'year' => '\d+',
                'month' => '\d+',
                'day' => '\d+',
            );
            break;
        case "slug_id":
            $path = $prefix . '/{slug}-{id}/';
            $defaults = array(
                '_controller' => 'nacholibreNewsBundle:Default:slugID',
            );
            $requirements = array(
                'id' => '\d+',
                'slug' => '.+',
            );
            break;
        case "slug":
            $path = $prefix . '/{slug}/';
            $defaults = array(
                '_controller' => 'nacholibreNewsBundle:Default:slug',
            );
            $requirements = array(
            );
            break;
        default:
            throw new \Exception('No such url type for nacholibre.news bundle: ' . $type);
        }

        $route = new Route($path, $defaults, $requirements);

        // add the new route to the route collection
        $routeName = 'nacholibre.news.show';
        $routes->add($routeName, $route);

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }
}
