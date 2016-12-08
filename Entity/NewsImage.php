<?php

namespace nacholibre\NewsBundle\Entity;

use nacholibre\RichUploaderBundle\Model\RichFile as nacholibreRichFile;
use nacholibre\RichUploaderBundle\Annotation\RichUploader;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="news_image")
 * @RichUploader(config="news_image")
 */
class NewsImage extends nacholibreRichFile {
}
