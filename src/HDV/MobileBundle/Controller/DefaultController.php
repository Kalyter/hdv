<?php

namespace HDV\MobileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use HDV\MobileBundle\Entity\Saisie;
use HDV\MobileBundle\Entity\Photo;
use HDV\MobileBundle\Form\SaisieType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{

    /**
     * @Route("/add")
     * @Security("has_role('ROLE_AUTEUR')")
     */
    public function indexAction(Request $request)
    {

      $saisie = new Saisie();
      $form   = $this->get('form.factory')->create(SaisieType::class, $saisie);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($saisie);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Le lot a été ajouté.');

        return $this->render('HDVMobileBundle:Default:index.html.twig', array(
          'form' => $form->createView(),

        ));
      }

        return $this->render('HDVMobileBundle:Default:index.html.twig', array(
          'form' => $form->createView(),

        ));
    }
}
