<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\VentesBundle\Entity\Ventes;
use HDV\MainBundle\Entity\Estimate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EstimateController extends Controller
{

    public function indexAction()
    {

              $listestimates = $this
             ->getDoctrine()
             ->getManager()
             ->getRepository('HDVMainBundle:Estimate')
             ->getAllEstimates()
            ;
              return $this->render('HDVAdminBundle:Estimate:index.html.twig', array(
                  'listestimates'           => $listestimates,
                ));

    }

    public function answerAction(Estimate $estimate, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user=$estimate->getUser();

        if(!$user)
        {
          $email=$estimate->getMail();
        }
        else
        {
          $email=$user->getEmail();
        }

          if($request->isXMLHttpRequest())
          {
            $message = $request->get('message');
            $this->get('admin.mailer')->sendEstimateAnswerMessage($estimate,$email,$message);
            $request->getSession()->getFlashBag()->add('success', 'Votre réponse a été envoyée par email.');
            $estimate->setAnswer(1);
            $estimate->setAnswercontent($message);
            $em->flush();

            return new JsonResponse(array('success' => true));
          }

        return $this->render('HDVAdminBundle:Estimate:answer.html.twig', array(
          'estimate' => $estimate
        ));
    }

    public function answermanualAction(Estimate $estimate, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

            $message="Répondu par un autre moyen.";
            $request->getSession()->getFlashBag()->add('success', 'La demande a été marqué comme répondu.');
            $estimate->setAnswer(1);
            $estimate->setAnswercontent($message);
            $em->flush();

         return $this->redirectToRoute('hdv_admin_estimate_home');
    }

    public function deleteAction(Estimate $estimate)
    {

          $em = $this->getDoctrine()->getEntityManager();
          $paths = $estimate->getImages();

          foreach($paths as $value) {
              $fullpath = __DIR__.'/../../../../web/images/estimate/'.$value;

              if(file_exists($fullpath)) {
                  unlink($fullpath);
              }
          }

          $em->remove($estimate);
          $em->flush();

          return $this->redirectToRoute('hdv_admin_estimate_home');
    }

}
