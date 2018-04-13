<?php

namespace HDV\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * @ORM\Table(name="hdv_user")
 * @ORM\Entity(repositoryClass="HDV\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   *
   * @ORM\Column(name="codedossier", type="integer", nullable=true)
   */
  protected $codedossier;

  /**
   * @var
   *
   * @ORM\Column(name="gender", type="string", length=255, nullable=true)
   */
  protected $gender;

  /**
   * @var
   *
   * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
   */
  protected $firstname;

  /**
   * @var
   *
   * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
   */
  protected $lastname;

  /**
   * @var
   *
   * @ORM\Column(name="address", type="string", length=255, nullable=true)
   */
  protected $address;

  /**
   * @var
   *
   * @ORM\Column(name="address2", type="string", length=255, nullable=true)
   */
  protected $address2;


  /**
   * @var
   *
   * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
   */
  protected $zipCode;

  /**
   * @var
   *
   * @ORM\Column(name="city", type="string", length=255, nullable=true)
   */
  protected $city;

  /**
   * @var
   *
   * @ORM\Column(name="country", type="string", length=255, nullable=true)
   */
  protected $country;

  /**
   * @var
   *
   * @ORM\Column(name="phone", type="string", length=255, nullable=true)
   */
  protected $phone;

  /**
   * @var
   *
   * @ORM\Column(name="phone2", type="string", length=255, nullable=true)
   */
  protected $phone2;

  /**
   * @ORM\OneToOne(targetEntity="HDV\UserBundle\Entity\Baccount", cascade={"persist"})
   */
  protected $bacc;

  /**
   *
   * @ORM\Column(name="validate", type="integer", options={"default":0})
   */
  protected $validate=0;

  /**
   * @ORM\OneToMany(targetEntity="HDV\VentesBundle\Entity\Ordres", mappedBy="user")
   */
 private $ordres;

  /**
   * Constructor
   */
  public function __construct()
  {
      parent::__construct();
  }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
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
     *
     * @return User
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
     * Set address
     *
     * @param string $address
     *
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return User
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return User
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
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
     * Set phone2
     *
     * @param string $phone2
     *
     * @return User
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Get phone2
     *
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    public function setEmail($email)
    {
    parent::setEmail($email);
    $this->setUsername($email);
  }

    /**
     * Set codedossier
     *
     * @param integer $codedossier
     *
     * @return User
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
     * Set validate
     *
     * @param integer $validate
     *
     * @return User
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }

    /**
     * Get validate
     *
     * @return integer
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set bacc
     *
     * @param \HDV\UserBundle\Entity\Baccount $bacc
     *
     * @return User
     */
    public function setBacc(\HDV\UserBundle\Entity\Baccount $bacc = null)
    {
        $this->bacc = $bacc;

        return $this;
    }

    /**
     * Get bacc
     *
     * @return \HDV\UserBundle\Entity\Baccount
     */
    public function getBacc()
    {
        return $this->bacc;
    }

    /**
     * Add ordre
     *
     * @param \HDV\VentesBundle\Entity\Ordres $ordre
     *
     * @return User
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
