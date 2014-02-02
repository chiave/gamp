<?php

namespace Chiave\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

// TODO: make some true constants!!
const PAGE_TYPE_REGULAR  = 0;
const PAGE_TYPE_CONTACT  = 1;
const PAGE_TYPE_MAIN     = 2;
const PAGE_TYPE_FILES    = 3;
const PAGE_TYPE_GALLERY  = 4;

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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type = PAGE_TYPE_REGULAR;

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
     * @ORM\OrderBy({"publicationDate" = "DESC"})
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
     * @ORM\Column(name="menuName", type="text", nullable=true)
     */
    private $menuName;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=32, unique=true, nullable=true)
     */
    private $slug = "";

    /**
     * @ORM\ManyToOne(targetEntity="Files")
     * @ORM\JoinColumn(name="icon_id", referencedColumnName="id", nullable=true)
     */
    private $icon;

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


    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set type
     *
     * @param integer $type
     * @return Pages
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get type as text
     *
     * @return string
     */
    public function getTypeText()
    {
        $types = $this->getTypesArray();
        return $types[$this->type];
    }

    /**
     * Get all types
     *
     * @return array
     */
    public static function getTypesArray()
    {
        return array(
            PAGE_TYPE_REGULAR   => 'zwykła',
            PAGE_TYPE_CONTACT   => 'kontaktowa',
            PAGE_TYPE_MAIN      => 'główna',
            PAGE_TYPE_FILES     => 'pliki',
            PAGE_TYPE_GALLERY   => 'galeria',
        );
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
    public function addArticle(\Chiave\CMSBundle\Entity\Articles $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove articles
     *
     * @param \Chiave\CMSBundle\Entity\Articles $articles
     */
    public function removeArticle(\Chiave\CMSBundle\Entity\Articles $article)
    {
        $this->articles->removeElement($article);
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
     * Set menuName
     *
     * @param string $menuName
     * @return Pages
     */
    public function setMenuName($menuName)
    {
        $this->menuName = $menuName;

        return $this;
    }

    /**
     * Get menuName
     *
     * @return string
     */
    public function getMenuName()
    {
        return $this->menuName;
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
     * Set icon
     *
     * @param \Chiave\CMSBundle\Entity\Files $icon
     * @return Pages
     */
    public function setIcon(\Chiave\CMSBundle\Entity\Files $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return \Chiave\CMSBundle\Entity\Files
     */
    public function getIcon()
    {
        return $this->icon;
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
