<?php

namespace HDV\VentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enquiry
 *
 * @ORM\Table(name="hdv_enquiry")
 * @ORM\Entity()
 */
class Enquiry
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="HDV\VentesBundle\Entity\Objects")
     * @ORM\JoinColumn(name="id_object", referencedColumnName="id")
     */
    private $object;

    /**
     * @ORM\ManyToOne(targetEntity="HDV\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(name="mail", type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @ORM\Column(name="answer", type="boolean")
     */
    private $answer = false;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Enquiry
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Enquiry
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Enquiry
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Enquiry
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
     * Set answer
     *
     * @param boolean $answer
     *
     * @return Enquiry
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return boolean
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set object
     *
     * @param \HDV\VentesBundle\Entity\Objects $object
     *
     * @return Enquiry
     */
    public function setObject(\HDV\VentesBundle\Entity\Objects $object = null)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \HDV\VentesBundle\Entity\Objects
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set user
     *
     * @param \HDV\UserBundle\Entity\User $user
     *
     * @return Enquiry
     */
    public function setUser(\HDV\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HDV\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
