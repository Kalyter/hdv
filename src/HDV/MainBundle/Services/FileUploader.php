<?php
namespace HDV\MainBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Kernel;

class FileUploader
{
    // Entity Manager
    private $em;
    private $validator;
    // The request
    private $request;

    // Kernel
    private $kernel;

    private $files;

    // Directory for the uploads
    private $directory;

    // File pathes array
    private $paths;

    // Constraint array
    private $constraints;

    // Array of file constraint object
    private $fileConstraints;

    // Error array
    private $errors;

    public function __construct(EntityManager $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
        $this->directory = 'bundles/images/estimate';
        $this->paths = array();
        $this->errors = array();
        $this->validator = Validation::createValidator();
    }

    // Create FileUploader object with constraints
    public function create($files, $constraints = NULL)
    {
        $this->files = $files;
        $this->constraints = $constraints;
        if($this->constraints)
        {
            $this->fileConstraints = $this->createFileConstraint($this->constraints);
        }
        return $this;
    }

    // Upload the file / handle errors
    // Returns boolean
    public function upload()
    {

        if(!$this->files) {
            return true;
        }

        foreach($this->files as $file) {
          if(isset($file)) {
                if($this->fileConstraints) {
                    $this->errors[] = $this->validator->validate($file, $this->fileConstraints);
                }

                $extension = $file->guessExtension();
                if(!$extension) {
                    $extension = 'bin';
                }
                $fileName = $this->createName().'.'.$extension;
                $this->paths[] = $fileName;

                if(!$this->hasErrors()) {
                    $file->move($this->getUploadRootDir(), $fileName);
                } else {
                    foreach($this->paths as $path) {
                        $fullpath = $this->getUploadRootDir().'/'.$path;

                        if(file_exists($fullpath)) {
                            unlink($fullpath);
                        }
                    }

                    $this->paths = null;
                    return false;
                }
            }
        }
        return true;
    }

    // Get array of relative file paths
    public function getFilePaths()
    {
        return $this->paths;
    }

    // Get array of error messages
    public function getErrors()
    {
        $errors = array();

        foreach($this->errors as $errorListItem) {
            foreach($errorListItem as $error) {
                $errors[] = $error->getMessage();
            }
        }
        return $errors;
    }

    protected function getUploadRootDir()
    {
      // On retourne le chemin relatif vers l'image pour notre code PHP
      return __DIR__.'/../../../../web/'.$this->directory;
    }

    // Generate random string for file name
    private function createName()
    {
        // Create name
        $image_name = uniqid('est_');
        return $image_name;
    }

    // Create array of file constraint objects
    private function createFileConstraint($constraints)
    {
        $fileConstraints = array();
        foreach($constraints as $constraintKey => $constraint) {
            $fileConstraint = new File();
            $fileConstraint->$constraintKey = $constraint;
            if($constraintKey == "mimeTypes") {
                $fileConstraint->mimeTypesMessage = "Seulement les photos au format .JPG/.GIF/.PNG sont autorisées.";
            }
            elseif($constraintKey == "maxSize") {
              $fileConstraint->maxSizeMessage = "Vos photos doivent faire moins de 4 MO.";
            }

            $fileConstraints[] = $fileConstraint;
        }

        return $fileConstraints;
    }

    // Check if there are constraint violations
    private function hasErrors()
    {
        if(count($this->errors) > 0) {
            foreach($this->errors as $error) {
                if($error->__toString()) {
                    return true;
                }
            }
        }
        return false;
    }
}
