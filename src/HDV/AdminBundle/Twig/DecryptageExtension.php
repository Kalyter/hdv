<?php

namespace HDV\AdminBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class DecryptageExtension extends \Twig_Extension
{

  private $twig;

  private $container;

      public function __construct(\Twig_Environment $twig, Container $container=null) {
          $this->container = $container;
          $this->twig = $twig;
      }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('decryptage', array($this, 'Decryptage')), // twig >= 1.12
        );
    }

    public function Decryptage($data)
    {
      $key = "hdvegb";
      $td = mcrypt_module_open(MCRYPT_DES,"",MCRYPT_MODE_ECB,"");
      $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
      mcrypt_generic_init($td,$key,$iv);
      $data = mdecrypt_generic($td, base64_decode($data));
      mcrypt_generic_deinit($td);

      if (substr($data,0,1) != '!')
          return false;

      $data = substr($data,1,strlen($data)-1);
      return unserialize($data);

    }

}
