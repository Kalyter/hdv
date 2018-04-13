<?php

namespace HDV\VentesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use HDV\VentesBundle\Form\OrdresType;
use HDV\VentesBundle\Entity\Ordres;
use Symfony\Component\HttpFoundation\Request;

class OrdresController extends Controller
{
    public function indexAction($object, $cata, Request $request)
    {
      $ordre = new Ordres();
      $form   = $this->get('form.factory')->create(OrdresType::class, $ordre, array(
    'action' => $this->generateUrl('hdv_ventes_object_ordre', array('object' => $object,'cata' => $cata))));

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $objectid = $em->getRepository('HDVVentesBundle:Objects')->find($object);
        $codevac = $objectid->getCodevac();
        $ordre->setCodevac($codevac);
        $ordre->setObject($objectid);
        $ordre->setUser($user);
        $em->persist($ordre);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Votre ordre a bien été enregistré.');

        if ($cata == 1)
        {
          return $this->render('HDVVentesBundle:Ordres:catordre.html.twig', array(
            'object' => $objectid,

          ));

        }
        else
        {
            return $this->redirectToRoute('hdv_ventes_object_view', array('id' => $object));
        }
      }

      return $this->render('HDVVentesBundle:Ordres:form.html.twig', array(
        'form' => $form->createView(),

      ));

    }

    public function catAction($objectcat)
    {
          $em = $this->getDoctrine()->getManager();

          $object = $em->getRepository('HDVVentesBundle:Objects')->find($objectcat);

          if (null === $object) {
            throw new NotFoundHttpException("L'objet n° ".$id." n'existe pas.");
          }
          return $this->render('HDVVentesBundle:Ordres:catordre.html.twig', array(
            'object' => $object,

          ));
    }


}
