<?php

namespace nacholibre\NewsBundle\Services;

class NewsManager {
    function __construct($em, $config) {
        $this->className = $config['entity_class'];
        $this->em = $em;
    }

    public function getRepo() {
        $repo = $this->em->getRepository($this->className);
        return $repo;
    }

    public function getLatestActiveNews($limit=10) {
        $repo = $this->em->getRepository($this->className);

        $posts = $repo->findBy([
            'active' => true
        ], [
            'id' => 'DESC'
        ]);

        return $posts;
    }
}
