<?php

namespace HDV\MobileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Saisie
 *
 * @ORM\Table(name="hdv_saisie")
 * @ORM\Entity(repositoryClass="HDV\MobileBundle\Repository\SaisieRepository")
 */
class Saisie
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
     * @var string
     *
     * @ORM\Column(name="dossier", type="string", length=255)
     */
    private $dossier;

    /**
    * @ORM\ManyToOne(targetEntity="HDV\VentesBundle\Entity\Famille")
    */
    private $famille;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="estb", type="string", length=255, nullable=true)
     */
    private $estb;

    /**
     * @var string
     *
     * @ORM\Column(name="esth", type="string", length=255, nullable=true)
     */
    private $esth;

    /**
     * @var int
     *
     * @ORM\Column(name="auteur", type="smallint")
     */
    private $auteur;

    /**
     * @var int
     *
     * @ORM\Column(name="ordre", type="smallint", nullable=true)
     */
    private $ordre;

    /**
     * @ORM\OneToOne(targetEntity="HDV\MobileBundle\Entity\Photo", cascade={"persist"})
     */
    private $image;


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
     * Set dossier
     *
     * @param string $dossier
     *
     * @return Saisie
     */
    public function setDossier($dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return string
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Saisie
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
     * Set estb
     *
     * @param string $estb
     *
     * @return Saisie
     */
    public function setEstb($estb)
    {
        $this->estb = $estb;

        return $this;
    }

    /**
     * Get estb
     *
     * @return string
     */
    public function getEstb()
    {
        return $this->estb;
    }

    /**
     * Set esth
     *
     * @param string $esth
     *
     * @return Saisie
     */
    public function setEsth($esth)
    {
        $this->esth = $esth;

        return $this;
    }

    /**
     * Get esth
     *
     * @return string
     */
    public function getEsth()
    {
        return $this->esth;
    }

    /**
     * Set auteur
     *
     * @param integer $auteur
     *
     * @return Saisie
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return int
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Saisie
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set famille
     *
     * @param \HDV\VentesBundle\Entity\Famille $famille
     *
     * @return Saisie
     */
    public function setFamille(\HDV\VentesBundle\Entity\Famille $famille = null)
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * Get famille
     *
     * @return \HDV\VentesBundle\Entity\Famille
     */
    public function getFamille()
    {
        return $this->famille;
    }

    /**
     * Set image
     *
     * @param \HDV\MobileBundle\Entity\Photo $image
     *
     * @return Saisie
     */
    public function setImage(\HDV\MobileBundle\Entity\Photo $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \HDV\MobileBundle\Entity\Photo
     */
    public function getImage()
    {
        return $this->image;
    }
}
