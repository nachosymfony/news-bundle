<?php

namespace nacholibre\NewsBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\MappedSuperclass
 * @ORM\Table(indexes={@ORM\Index(name="post_slug", columns={"slug"}), @ORM\Index(name="date_slug", columns={"created_date_slug"})})
 * @UniqueEntity("title")
 * @Vich\Uploadable
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @Assert\NotBlank()
    * @Gedmo\Translatable
    * @ORM\Column(type="string", length=255, unique=true)
    */
    protected $title;

    /**
    * @Assert\NotBlank()
    * @Gedmo\Translatable
    * @ORM\Column(type="text")
    */
    protected $content;

    /**
    * @Gedmo\Translatable
    * @ORM\Column(type="string", length=255, unique=true, nullable=false)
    */
    protected $slug;

    /**
    * @ORM\Column(type="boolean")
    */
    protected $active = true;

    /**
    * @ORM\Column(type="boolean")
    */
    protected $commentsEnabled = true;

    /**
    * @ORM\Column(type="date")
    */
    protected $createdDateSlug;

    /**
    * @ORM\Column(type="datetime", nullable=true)
    */
    protected $startDate;

    /**
    * @Gedmo\Timestampable(on="create")
    * @ORM\Column(type="datetime")
    */
    protected $createdAt;

    /**
    * @Gedmo\Timestampable(on="update")
    * @ORM\Column(type="datetime", nullable=true)
    */
    protected $modifiedAt;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="FOS\UserBundle\Model\UserInterface")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="FOS\UserBundle\Model\UserInterface")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     */
    protected $updatedBy;

    /**
     * @ORM\OneToOne(targetEntity="nacholibre\NewsBundle\Entity\NewsImage")
     */
    protected $image;

    function __construct() {
        $this->setCreatedDateSlug(new \Datetime());
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Post
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set commentsEnabled
     *
     * @param boolean $commentsEnabled
     * @return Post
     */
    public function setCommentsEnabled($commentsEnabled)
    {
        $this->commentsEnabled = $commentsEnabled;

        return $this;
    }

    /**
     * Get commentsEnabled
     *
     * @return boolean 
     */
    public function getCommentsEnabled()
    {
        return $this->commentsEnabled;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Post
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     * @return Post
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime 
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    public function setCreatedDateSlug($slug) {
        $this->createdDateSlug = $slug;
    }

    public function getCreatedDateSlug() {
        return $this->createdDateSlug;
    }
}
