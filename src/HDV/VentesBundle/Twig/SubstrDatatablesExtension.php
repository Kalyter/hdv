<?php

namespace HDV\VentesBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class SubstrDatatablesExtension extends \Twig_Extension
{

  private $twig;

      public function __construct(\Twig_Environment $twig) {
          $this->twig = $twig;
      }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('substrdatatables', array($this, 'SubstrDatatables')), // twig >= 1.12
        );
    }

    public function SubstrDatatables($arg)
    {
              $chaine = $arg;
              $lg_max = 250;

          if($arg)
          {
               if (strlen($chaine) > $lg_max)
                {
                $chaine = substr($chaine, 0, $lg_max);
                $last_space = strrpos($chaine, " ");
                $chaine = substr($chaine, 0, $last_space)." [...]";
                }
              return $chaine;
          }
          else {
            return $chaine;
          }

    }

}
