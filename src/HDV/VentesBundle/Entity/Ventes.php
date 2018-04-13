<?php

namespace HDV\VentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Ventes
 *
 * @ORM\Table(name="hdv_ventes")
 * @ORM\Entity(repositoryClass="HDV\VentesBundle\Repository\VentesRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ventes
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
      * @ORM\OneToMany(targetEntity="HDV\VentesBundle\Entity\Objects", mappedBy="codevac")
      */
    private $objects;

    /**
     * @ORM\OneToMany(targetEntity="HDV\VentesBundle\Entity\Ordres", mappedBy="codevac")
     */
   private $ordres;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="conditions", type="text", nullable=true)
     */
    private $conditions;

    /**
     * @ORM\OneToOne(targetEntity="HDV\VentesBundle\Entity\Image", cascade={"persist"})
     */
    private $image;

    /**
     * @ORM\Column(name="catpublished", type="boolean")
     */
    private $catpublished = false;

    /**
     *
     * @ORM\Column(name="liveurl", type="string", length=255)
     */
    private $liveurl;

  public function __construct()
  {
    $this->date         = new \Datetime();
    $this->objects   = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Ventes
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Ventes
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
     * Set description
     *
     * @param string $description
     *
     * @return Ventes
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
     * Set conditions
     *
     * @param string $conditions
     *
     * @return Ventes
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set image
     *
     * @param \HDV\VentesBundle\Entity\Image $image
     *
     * @return Ventes
     */
    public function setImage(\HDV\VentesBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \HDV\VentesBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add object
     *
     * @param \HDV\VentessBundle\Entity\Objects $object
     *
     * @return Ventes
     */
    public function addObject(\HDV\VentesBundle\Entity\Objects $object)
    {
        $this->objects[] = $object;

        return $this;
    }

    /**
     * Remove object
     *
     * @param \HDV\VentesBundle\Entity\Objects $object
     */
    public function removeObject(\HDV\VentesBundle\Entity\Objects $object)
    {
        $this->objects->removeElement($object);
    }

    /**
     * Get objects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObjects()
    {
        return $this->objects;
    }

    public function __toString()
 {
     return strval($this->id);
 }


    /**
     * Set catpublished
     *
     * @param boolean $catpublished
     *
     * @return Ventes
     */
    public function setCatpublished($catpublished)
    {
        $this->catpublished = $catpublished;

        return $this;
    }

    /**
     * Get catpublished
     *
     * @return boolean
     */
    public function getCatpublished()
    {
        return $this->catpublished;
    }

    /**
     * Add ordre
     *
     * @param \HDV\VentesBundle\Entity\Ordres $ordre
     *
     * @return Ventes
     */
    public function addOrdre(\HDV\VentesBundle\Entity\Ordres $ordre)
    {
        $this->ordres[] = $ordre;

        return $this;
    }

    /**
     * Remove ordre
     *
     * @param \HDV\VentesBundle\Entity\Ordres $ordre
     */
    public function removeOrdre(\HDV\VentesBundle\Entity\Ordres $ordre)
    {
        $this->ordres->removeElement($ordre);
    }

    /**
     * Get ordres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrdres()
    {
        return $this->ordres;
    }

    /**
     * Set liveurl
     *
     * @param string $liveurl
     *
     * @return Ventes
     */
    public function setLiveurl($liveurl)
    {
        $this->liveurl = $liveurl;

        return $this;
    }

    /**
     * Get liveurl
     *
     * @return string
     */
    public function getLiveurl()
    {
        return $this->liveurl;
    }

}
