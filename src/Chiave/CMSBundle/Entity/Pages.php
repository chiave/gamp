<?php

namespace Chiave\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pages
 *
 * @ORM\Table(name="cms_pages")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Pages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="staticContent", type="text", nullable=true)
     */
    private $staticContent;

    /**
     * @ORM\OneToMany(targetEntity="Articles", mappedBy="page")
     **/
    private $articles;

    /**
     * @var boolean
     *
     * @ORM\Column(name="inMenu", type="boolean", nullable=true)
     */
    private $inMenu = false;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=32)
     */
    private $slug;

    // *
    //  * @var string
    //  *
    //  * @ORM\Column(name="image", type="string", length=32)
     
    // private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * To string
     */
    public function __toString()
    {
        return $this->title;
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
     * @return Pages
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
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Pages
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set staticContent
     *
     * @param string $staticContent
     * @return Pages
     */
    public function setStaticContent($staticContent)
    {
        $this->staticContent = $staticContent;

        return $this;
    }

    /**
     * Get staticContent
     *
     * @return string 
     */
    public function getStaticContent()
    {
        return $this->staticContent;
    }

    /**
     * Add articles
     *
     * @param \Chiave\CMSBundle\Entity\Articles $articles
     * @return Pages
     */
    public function addArticle(\Chiave\CMSBundle\Entity\Articles $articles)
    {
        $this->articles[] = $articles;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Chiave\CMSBundle\Entity\Articles $articles
     */
    public function removeArticle(\Chiave\CMSBundle\Entity\Articles $articles)
    {
        $this->articles->removeElement($articles);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set inMenu
     *
     * @param boolean $inMenu
     * @return Pages
     */
    public function setInMenu($inMenu)
    {
        $this->inMenu = $inMenu;

        return $this;
    }

    /**
     * Get inMenu
     *
     * @return boolean 
     */
    public function getInMenu()
    {
        return $this->inMenu;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Pages
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
     * Set position
     *
     * @param integer $position
     * @return Pages
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Pages
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
     * @ORM\PrePersist
     */
    public function setInitialTimestamps()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Pages
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedTimestamps()
    {
        $this->updatedAt = new \DateTime('now');
    }
}
