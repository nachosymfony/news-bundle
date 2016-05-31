<?php

namespace nacholibre\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Post
{
    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id()
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $title;

    /**
    * @ORM\Column(type="text")
    */
    private $content;

    /**
    * @ORM\Column(type="string", length=255, nullable=false)
    */
    private $slug;

    /**
    * @ORM\Column(type="boolean")
    */
    private $active = true;

    /**
    * @ORM\Column(type="boolean")
    */
    private $commentsEnabled = true;

    /**
    * @ORM\Column(type="datetime")
    */
    private $startDate;

    /**
    * @ORM\Column(type="datetime")
    */
    private $createdAt;

    /**
    * @ORM\Column(type="datetime")
    */
    private $modifiedAt;

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
}
