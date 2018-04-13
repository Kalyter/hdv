<?php

namespace HDV\VentesBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ImagesmultipleExtension extends \Twig_Extension
{

  private $twig;

      public function __construct(\Twig_Environment $twig) {
          $this->twig = $twig;
      }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('imgmultiple', array($this, 'imagesMultiple')), // twig >= 1.12
        );
    }

    public function imagesMultiple($arg, $arg2, $size='25')
    {
        $imgs = '';

        $vente=$arg2;

          if(isset($arg))
          {
            $images = explode("\n", $arg);

            return $this->twig->render('HDVVentesBundle:Ventes:images.html.twig', array('images' => $images, 'vente' => $vente, 'size' => $size));

          }
          else {
            return $imgs;
          }

    }

}
