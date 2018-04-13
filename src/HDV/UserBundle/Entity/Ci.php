<?php
namespace HDV\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Ci
{
  /**
   * @Assert\File(
   *     maxSize = "6M",
   *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "application/pdf", "application/x-pdf"},
   *     mimeTypesMessage = "Votre fichier doit être au format PDF, JPG ou PNG."
   * )
   */
    public $file;

    public function getFile()
    {
      return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
      $this->file = $file;
    }


}
