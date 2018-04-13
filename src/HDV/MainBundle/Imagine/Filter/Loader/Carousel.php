<?php

namespace HDV\MainBundle\Imagine\Filter\Loader;

use Imagine\Image\ImageInterface;
use Liip\ImagineBundle\Imagine\Filter\Loader\LoaderInterface;
use Imagine\Filter\Basic\Crop;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Liip\ImagineBundle\Imagine\Filter\RelativeResize;

class Carousel implements LoaderInterface
{
    /**
     * @param ImageInterface $image
     * @param array          $options
     *
     * @return ImageInterface
     */
    public function load(ImageInterface $image, array $options = array())
    {
      $method = "widen";
      $parameter = "720";
      $filter = new RelativeResize($method, $parameter);
      $image = $filter->apply($image);

      $size = $image->getSize();
      $width  = $size->getWidth();
      $height = $size->getHeight();

      $centreX = round($width / 2);
      $centreY = round($height / 2);

    $x1 = $centreX - 290;
    $y1 = $centreY - 130;

    $x2 = $centreX + 290;
    $y2 = $centreY + 130;

      $filter = new Crop(new Point($x1, $y1), new Box(580, 260));
      $image = $filter->apply($image);

      return $image;

    }
}
