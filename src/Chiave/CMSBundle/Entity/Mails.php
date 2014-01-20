<?php

namespace Chiave\CMSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

// TODO: make some true constants!!
const MAIL_TYPE_CONTACT  = 0;
const MAIL_TYPE_TRAINING_QUESTION  = 1;
const MAIL_TYPE_TRAINING_SIGN_UP  = 2;
const MAIL_TYPE_OFFER  = 3;
const MAIL_TYPE_BREAKAGE  = 4;

/**
 * Mails
 *
 * @ORM\Table(name="cms_mails")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Mails
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type = MAIL_TYPE_CONTACT;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=64, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=128, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

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
     * Set type
     *
     * @param integer $type
     * @return Mails
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
        if ($this->type != MAIL_TYPE_CONTACT) {
            $types = $this->getTypesArray();
            return $types[$this->type];
        } else {
            return 'Kontakt';
        }
    }

    /**
     * Get all types
     *
     * @return array
     */
    public static function getTypesArray()
    {
        return array(
            // MAIL_TYPE_CONTACT => 'kontakt',
            MAIL_TYPE_TRAINING_QUESTION => 'Zapytanie o kurs/szkolenie',
            MAIL_TYPE_TRAINING_SIGN_UP => 'Zgłoszenie na kurs/szkolenie',
            MAIL_TYPE_OFFER => 'Zapytanie ofertowe',
            MAIL_TYPE_BREAKAGE => 'Zgłoszenie usterki',
        );
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Mails
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Mails
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Mails
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Mails
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Mails
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @ORM\PrePersist
     */
    public function setInitialTimestamps()
    {
        $this->createdAt = new \DateTime('now');
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Mails
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
