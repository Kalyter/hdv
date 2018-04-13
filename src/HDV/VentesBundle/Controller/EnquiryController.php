<?php

namespace HDV\VentesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use HDV\VentesBundle\Form\EnquiryType;
use HDV\VentesBundle\Form\EnquiryLogType;
use HDV\VentesBundle\Entity\Enquiry;
use HDV\VentesBundle\Entity\Objects;
use Symfony\Component\HttpFoundation\Request;

class EnquiryController extends Controller
{

    public function indexAction(Objects $object, Request $request)
    {

      $enquiry = new Enquiry();
      $user = $this->getUser();

      if (!$user)
      {
      $form   = $this->get('form.factory')->create(EnquiryType::class, $enquiry);
      }
      else
      {
      $form   = $this->get('form.factory')->create(EnquiryLogType::class, $enquiry);
      }

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $enquiry->setObject($object);
        $enquiry->setUser($user);
        $em->persist($enquiry);
        $em->flush();


        $request->getSession()->getFlashBag()->add('success', 'Votre demande de renseignements a été enregistrée.');

        return $this->render('HDVVentesBundle:Enquiry:index.html.twig', array(
          'form' => $form->createView(),
          'object' => $object,

        ));
      }

      return $this->render('HDVVentesBundle:Enquiry:index.html.twig', array(
        'form' => $form->createView(),
        'object' => $object,

      ));

    }




}
