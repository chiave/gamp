<?php

namespace Chiave\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entries
 *
 * @ORM\Table(name="cms_entries")
 * @ORM\Entity
 */
class Entries
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
     * @ORM\Column(name="header", type="string", length=511)
     */
    private $header;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="entries")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     **/
    private $article;


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
     * @return Entries
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
     * Set content
     *
     * @param string $content
     * @return Entries
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
     * Set article
     *
     * @param \Chiave\CMSBundle\Entity\Articles $article
     * @return Entries
     */
    public function setArticle(\Chiave\CMSBundle\Entity\Articles $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \Chiave\CMSBundle\Entity\Articles
     */
    public function getArticle()
    {
        return $this->article;
    }
}
