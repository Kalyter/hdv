<?php

namespace HDV\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * News
 *
 * @ORM\Table(name="hdv_news")
 * @ORM\Entity(repositoryClass="HDV\MainBundle\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class News
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = false;

    /**
     * @ORM\OneToOne(targetEntity="HDV\MainBundle\Entity\Image", cascade={"persist"})
     */
    private $image;


  public function __construct()
  {
    $this->date         = new \Datetime();
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
     * Set content
     *
     * @param string $description
     *
     * @return Ventes
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
     * Set image
     *
     * @param \HDV\MainBundle\Entity\Image $image
     *
     * @return Main
     */
    public function setImage(\HDV\MainBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \HDV\MainBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }




    /**
     * Set published
     *
     * @param boolean $catpublished
     *
     * @return Main
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }


}
