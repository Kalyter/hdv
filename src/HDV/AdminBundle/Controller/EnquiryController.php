<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\VentesBundle\Entity\Ventes;
use HDV\VentesBundle\Entity\Enquiry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class EnquiryController extends Controller
{

    public function indexAction()
    {

              $listenq = $this
             ->getDoctrine()
             ->getManager()
             ->getRepository('HDVVentesBundle:Enquiry')
             ->findAll();

              return $this->render('HDVAdminBundle:Enquiry:index.html.twig', array(
                  'listenq'           => $listenq,
                ));

    }

    public function printAction(Enquiry $enquiry)
    {

      return $this->render('HDVAdminBundle:Enquiry:print.html.twig', array(
          'enquiry'           => $enquiry,
        ));

    }

    public function answerAction(Enquiry $enquiry, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$enquiry->getUser();

        if(!$user)
        {
          $email=$enquiry->getMail();
        }
        else
        {
          $email=$user->getEmail();
        }
          if($request->isXMLHttpRequest())
          {
            $message = $request->get('message');
            $this->get('admin.mailer')->sendEnquiryAnswerMessage($enquiry,$email,$message);
            $request->getSession()->getFlashBag()->add('success', 'Votre réponse a été envoyée par email.');
            $enquiry->setAnswer(1);
            $em->flush();

            return new JsonResponse(array('success' => true));
          }

        return $this->render('HDVAdminBundle:Enquiry:answer.html.twig', array(
          'enquiry' => $enquiry
        ));
    }


}
