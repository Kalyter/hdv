<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\AdminBundle\Entity\Images;
use HDV\VentesBundle\Entity\Ventes;
use HDV\VentesBundle\Entity\Objects;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadController extends Controller
{

public function ajaxSnippetImageSendAction(Request $request, $idvente)
{
    $em = $this->container->get("doctrine.orm.default_entity_manager");

    $document = new Images();
    $media = $request->files->get('file');
    $document->setFile($media);
    $document->upload($idvente);

    //var_dump($request->files->get('file'));die;
    return new JsonResponse(array('success' => true));
}

public function indexAction(Request $request, $idvente)
{

      $em = $this->getDoctrine()->getManager();

      $vente = $em->getRepository('HDVVentesBundle:Ventes')->find($idvente);

          return $this->render('HDVAdminBundle:Objects:upload.html.twig', array(
              'vente'           => $vente,
            ));


}

          public function morepicturesAction(Objects $object, Request $request)
          {

               return $this->render('HDVAdminBundle:Objects:uploadmore.html.twig', array(
                        'object'           => $object,
                      ));


          }

          public function ajaxSnippetImageMoreSendAction(Objects $object, Request $request)
          {
              $em = $this->container->get("doctrine.orm.default_entity_manager");


              $document = new Images();
              $media = $request->files->get('file');
              if(isset($media))
              {
                # code...
              $document->setFile($media);
              $filename = $media->getClientOriginalName();
              $imgmain = $object->getImage();
              $imgsupp = $object->getImagesupp();

              if(empty($imgmain))
              {
                $object->setImage($filename);
              }
              else
              {
                      if(empty($imgsupp))
                      {
                      $imgsuppok = $filename;
                      }
                      else
                      {
                      $imgsuppok = $filename."\n".$imgsupp;
                      }
                  $object->setImagesupp($imgsuppok);
                }


              $document->upload($object->getCodevac());
              $em->flush();
              }
              //var_dump($request->files->get('file'));die;
              return new JsonResponse(array('success' => true));
          }

}
