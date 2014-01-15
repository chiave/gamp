<?php

namespace Chiave\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

const TYPE_REGULAR  = 0;
const TYPE_LIST     = 1;
const TYPE_TAB      = 2;

/**
 * Articles
 *
 * @ORM\Table(name="cms_articles")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Articles
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
     * @ORM\Column(name="header", type="string", length=255)
     */
    private $header;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="staticContent", type="text", nullable=true)
     */
    private $staticContent;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type = TYPE_REGULAR;

    /**
     * @var boolean
     *
     * @ORM\Column(name="root", type="boolean", nullable=true)
     */
    private $root = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expandable", type="boolean", nullable=true)
     */
    private $expandable = false;

    /**
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="childrens")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Articles", mappedBy="parent")
     */
    private $childrens;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var boolean
     *
     * @ORM\Column(name="important", type="boolean", nullable=true)
     */
    private $important = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publicationDate", type="datetime")
     */
    private $publicationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Pages", inversedBy="articles")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     **/
    private $page;

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
     * To string
     */
    public function __toString()
    {
        return $this->header;
    }

    public function __construct() {
        $this->childrens = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set header
     *
     * @param string $header
     * @return Articles
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string 
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return Articles
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
     * Set description
     *
     * @param string $description
     * @return Articles
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * Set type
     *
     * @param integer $type
     * @return Articles
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
     * Get all types
     *
     * @return array
     */
    public static function getTypesArray()
    {
        return array(
            0 => 'wpis',
            1 => 'lista',
            2 => 'zakładka',
        );
    }

    /**
     * Set root
     *
     * @param boolean $root
     * @return Articles
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return boolean 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set expandable
     *
     * @param boolean $expandable
     * @return Articles
     */
    public function setExpandable($expandable)
    {
        $this->expandable = $expandable;

        return $this;
    }

    /**
     * Get expandable
     *
     * @return boolean
     */
    public function getExpandable()
    {
        return $this->expandable;
    }

    /**
     * Set parent
     *
     * @param \Chiave\CMSBundle\Entity\Articles $parent
     * @return Articles
     */
    public function setParent(\Chiave\CMSBundle\Entity\Articles $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Chiave\CMSBundle\Entity\Articles 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add childrens
     *
     * @param \Chiave\CMSBundle\Entity\Articles $childrens
     * @return Articles
     */
    public function addChildren(\Chiave\CMSBundle\Entity\Articles $childrens)
    {
        $this->childrens[] = $childrens;

        return $this;
    }

    /**
     * Remove childrens
     *
     * @param \Chiave\CMSBundle\Entity\Articles $childrens
     */
    public function removeChildren(\Chiave\CMSBundle\Entity\Articles $childrens)
    {
        $this->childrens->removeElement($childrens);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Articles
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
     * Set important
     *
     * @param boolean $important
     * @return Articles
     */
    public function setImportant($important)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * Get important
     *
     * @return boolean 
     */
    public function getImportant()
    {
        return $this->important;
    }

    /**
     * Set publicationDate
     *
     * @param \DateTime $publicationDate
     * @return Articles
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return \DateTime 
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Set page
     *
     * @param \Chiave\CMSBundle\Entity\Pages $page
     * @return Articles
     */
    public function setPage(\Chiave\CMSBundle\Entity\Pages $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \Chiave\CMSBundle\Entity\Pages 
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Articles
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
     * @return Articles
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
