<?php

namespace HDV\VentesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Objects
 *
 * @ORM\Table(name="hdv_objects")
 * @ORM\Entity(repositoryClass="HDV\VentesBundle\Repository\ObjectsRepository")
 */
class Objects
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
     * @ORM\ManyToOne(targetEntity="HDV\VentesBundle\Entity\Ventes", inversedBy="objects", cascade={"persist"})
     * @ORM\JoinColumn(name="codevac", referencedColumnName="id")
     */
    private $codevac;

    /**
     * @ORM\OneToMany(targetEntity="HDV\VentesBundle\Entity\Ordres", mappedBy="object")
     */
   private $ordres;

    /**
     *
     * @ORM\Column(name="codedossier", type="integer", nullable=true)
     */
    private $codedossier;

    /**
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @ORM\Column(name="ordre", type="integer", nullable=false)
     */
    private $ordre;

    /**
     *
     * @ORM\Column(name="ordrebis", type="string", length=255, nullable=true)
     */
    private $ordrebis;

    /**
     *
     * @ORM\Column(name="estimbasse", type="integer", nullable=true)
     */
    private $estimbasse;

    /**
     *
     * @ORM\Column(name="estimhaute", type="integer", nullable=true)
     */
    private $estimhaute;

    /**
     *
     * @ORM\Column(name="adjuge", type="integer", nullable=true)
     */
    private $adjuge;

    /**
     *
     * @ORM\Column(name="codeacq", type="integer", nullable=true)
     */
    private $codeacq;

    /**
    * @ORM\ManyToOne(targetEntity="HDV\VentesBundle\Entity\Famille")
    */
    private $famille;

    /**
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     *
     * @ORM\Column(name="imagesupp", type="text", nullable=true)
     */
    private $imagesupp;

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
     * Set codedossier
     *
     * @param integer $codedossier
     *
     * @return Objects
     */
    public function setCodedossier($codedossier)
    {
        $this->codedossier = $codedossier;

        return $this;
    }

    /**
     * Get codedossier
     *
     * @return integer
     */
    public function getCodedossier()
    {
        return $this->codedossier;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Objects
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
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Objects
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set ordrebis
     *
     * @param string $ordrebis
     *
     * @return Objects
     */
    public function setOrdrebis($ordrebis)
    {
        $this->ordrebis = $ordrebis;

        return $this;
    }

    /**
     * Get ordrebis
     *
     * @return string
     */
    public function getOrdrebis()
    {
        return $this->ordrebis;
    }

    /**
     * Set estimbasse
     *
     * @param integer $estimbasse
     *
     * @return Objects
     */
    public function setEstimbasse($estimbasse)
    {
        $this->estimbasse = $estimbasse;

        return $this;
    }

    /**
     * Get estimbasse
     *
     * @return integer
     */
    public function getEstimbasse()
    {
        return $this->estimbasse;
    }

    /**
     * Set estimhaute
     *
     * @param integer $estimhaute
     *
     * @return Objects
     */
    public function setEstimhaute($estimhaute)
    {
        $this->estimhaute = $estimhaute;

        return $this;
    }

    /**
     * Get estimhaute
     *
     * @return integer
     */
    public function getEstimhaute()
    {
        return $this->estimhaute;
    }

    /**
     * Set adjuge
     *
     * @param integer $adjuge
     *
     * @return Objects
     */
    public function setAdjuge($adjuge)
    {
        $this->adjuge = $adjuge;

        return $this;
    }

    /**
     * Get adjuge
     *
     * @return integer
     */
    public function getAdjuge()
    {
        return $this->adjuge;
    }

    /**
     * Set codeacq
     *
     * @param integer $codeacq
     *
     * @return Objects
     */
    public function setCodeacq($codeacq)
    {
        $this->codeacq = $codeacq;

        return $this;
    }

    /**
     * Get codeacq
     *
     * @return integer
     */
    public function getCodeacq()
    {
        return $this->codeacq;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Objects
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set imagesupp
     *
     * @param string $imagesupp
     *
     * @return Objects
     */
    public function setImagesupp($imagesupp)
    {
        $this->imagesupp = $imagesupp;

        return $this;
    }

    /**
     * Get imagesupp
     *
     * @return string
     */
    public function getImagesupp()
    {
        return $this->imagesupp;
    }

    /**
     * Set codevac
     *
     * @param \HDV\VentesBundle\Entity\Ventes $codevac
     *
     * @return Objects
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
     * Set famille
     *
     * @param \HDV\VentesBundle\Entity\Famille $famille
     *
     * @return Objects
     */
    public function setFamille(\HDV\VentesBundle\Entity\Famille $famille = null)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return \HDV\ObjectsBundle\Entity\Famille
     */
    public function getFamille()
    {
        return $this->famille;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ordres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ordre
     *
     * @param \HDV\VentesBundle\Entity\Ordres $ordre
     *
     * @return Objects
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
}
