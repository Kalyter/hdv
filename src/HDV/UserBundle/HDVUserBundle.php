<?php

namespace HDV\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HDVUserBundle extends Bundle
{
  public function getParent()
{
  return 'FOSUserBundle';
}

}
