<?php

namespace HDV\VentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ordres
 *
 * @ORM\Table(name="hdv_ordres")
 * @ORM\Entity(repositoryClass="HDV\VentesBundle\Repository\OrdresRepository")
 */
class Ordres
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
     * @ORM\ManyToOne(targetEntity="HDV\VentesBundle\Entity\Ventes", inversedBy="ordres")
     * @ORM\JoinColumn(name="id_codevac", referencedColumnName="id")
     */
    private $codevac;

    /**
     * @ORM\ManyToOne(targetEntity="HDV\VentesBundle\Entity\Objects", inversedBy="ordres")
     * @ORM\JoinColumn(name="id_object", referencedColumnName="id")
     */
    private $object;

    /**
     * @ORM\ManyToOne(targetEntity="HDV\UserBundle\Entity\User", inversedBy="ordres")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(name="montant", type="string", length=255, nullable=true)
     */
    private $montant;

    /**
     * @ORM\Column(name="validate", type="boolean")
     */
    private $validate = false;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set type
     *
     * @param string $type
     *
     * @return Ordres
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return Ordres
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set validate
     *
     * @param boolean $validate
     *
     * @return Ordres
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }

    /**
     * Get validate
     *
     * @return boolean
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set codevac
     *
     * @param \HDV\VentesBundle\Entity\Ventes $codevac
     *
     * @return Ordres
     */
    public function setCodevac(\HDV\VentesBundle\Entity\Ventes $codevac = null)
    {
        $this->codevac = $codevac;

        return $this;
    }

    /**
     * Get codevac
     *
     * @return \HDV\VentesBundle\Entity\Ventes
     */
    public function getCodevac()
    {
        return $this->codevac;
    }

    /**
     * Set object
     *
     * @param \HDV\VentesBundle\Entity\Objects $object
     *
     * @return Ordres
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
     * @return Ordres
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
