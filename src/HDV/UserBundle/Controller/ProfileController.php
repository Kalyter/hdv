<?php

namespace HDV\UserBundle\Controller;

use HDV\UserBundle\Entity\User;
use HDV\VentesBundle\Entity\Ordres;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use HDV\UserBundle\Entity\Baccount;
use HDV\UserBundle\Entity\Ci;
use HDV\UserBundle\Form\BaccountType;
use HDV\UserBundle\Form\EditCoordType;
use HDV\UserBundle\Form\CiType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProfileController extends BaseController
{


      public function ventesAction(Request $request)
      {

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $dossier = $user->getCodedossier();

          if($dossier == 0)
          {
            $request->getSession()->getFlashBag()->add('warning', 'Vous ne pouvez pas accéder à cette page.
            Votre code dossier n\'a pas été renseigné. Merci de nous contacter si vous pensez qu\'il s\'agit d\'une erreur.');
            return $this->redirectToRoute('fos_user_profile_show');
          }

        $listObjects = $em
          ->getRepository('HDVVentesBundle:Objects')
          ->findBy(
            array('codedossier' => $dossier),
            array('codevac' => 'desc')
          );


        return $this->render('HDVUserBundle:Ventes:view.html.twig', array(
          'listObjects' => $listObjects,
        ));
      }

      public function achatsAction(Request $request)
      {

        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $dossier = $user->getCodedossier();

          if($dossier == 0)
          {
            $request->getSession()->getFlashBag()->add('warning', 'Vous ne pouvez pas accéder à cette page.
            Votre code dossier n\'a pas été renseigné. Merci de nous contacter si vous pensez qu\'il s\'agit d\'une erreur.');
            return $this->redirectToRoute('fos_user_profile_show');
          }

        $listObjects = $em
          ->getRepository('HDVVentesBundle:Objects')
          ->findBy(
            array('codeacq' => $dossier),
            array('codevac' => 'desc')
          );


        return $this->render('HDVUserBundle:Ventes:viewacq.html.twig', array(
          'listObjects' => $listObjects,
        ));
      }


      public function baccountAction(Request $request)
      {

        $user = $this->getUser();
        $bacc = $user->getBacc();

        if (empty($bacc))
        {
          $baccount = new Baccount();
          $form   = $this->get('form.factory')->create(BaccountType::class, $baccount);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
              $em = $this->getDoctrine()->getManager();

              $bic = $form->getData()->getBic();
              $iban = $form->getData()->getIban();

              $crypter = $this->container->get('Encrypt.Decrypt');
              $databic = $crypter->encrypt($bic);
              $dataiban = $crypter->encrypt($iban);

              $baccount->setBic($databic);
              $baccount->setIban($dataiban);

                if($user->getValidate() == 0)
                {
                  $user->setValidate(1);
                }

              $em->persist($baccount);
              $user->setBacc($baccount);
              $em->flush();

              $request->getSession()->getFlashBag()->add('success', 'Vos informations bancaires ont été mises à jour.');
              return $this->redirectToRoute('fos_user_profile_show');
            }

        }
        else
        {
          $form   = $this->get('form.factory')->create(BaccountType::class, $bacc);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
             {
              $em = $this->getDoctrine()->getManager();
              $bic = $form->getData()->getBic();
              $iban = $form->getData()->getIban();

              $crypter = $this->container->get('Encrypt.Decrypt');
              $data = $crypter->encrypt($bic);
              $data2 = $crypter->encrypt($iban);

              $bacc->setBic($data);
              $bacc->setIban($data2);

                if($user->getValidate() == 0)
                {
                  $user->setValidate(1);
                }

              $em->flush();

              $request->getSession()->getFlashBag()->add('success', 'Vos informations bancaires ont été mises à jour.');
              return $this->redirectToRoute('fos_user_profile_show');
            }
        }
        return $this->render('HDVUserBundle:Profile:baccount.html.twig', array(
          'form' => $form->createView(),

        ));

      }

      public function mailAction(Request $request)
      {

        $user = $this->getUser();
        $file = new Ci();
        $form   = $this->get('form.factory')->create(CiType::class, $file);

            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
            {
                  $filename = $form->get('file')->getData();
                  $filename->move(__DIR__.'/../../../../web/bundles/file/', $filename->getClientOriginalName());

                  $tomail = $this->container->getParameter('mailer_user');
                  $message = \Swift_Message::newInstance();
                  $message->setSubject('Demande de validation de compte de '.$user->getGender().' '.$user->getFirstname());
                  $message->setFrom("contact@enghien-svv.com");
                  $message->setTo("contact@enghien-svv.com");
                  $message->setBody( $this->renderView('HDVUserBundle:Profile:mailci_content.html.twig',array('user' => $user)),'text/html');
                  $message->attach(\Swift_Attachment::fromPath(__DIR__.'/../../../../web/bundles/file/'.$filename->getClientOriginalName()));

                  $result = $this->get('mailer')->send($message);
                  $transport = $this->container->get('mailer')->getTransport();
                  $spool = $transport->getSpool();
                  $spool->flushQueue($this->container->get('swiftmailer.transport.real'));

                  unlink(__DIR__.'/../../../../web/bundles/file/'.$filename->getClientOriginalName());
                  $validstatus = $user->getValidate();

                  if( $validstatus == 1)
                  {
                    $em = $this->getDoctrine()->getManager();
                    $user->setValidate(2);
                    $em->flush();
                  }

              $request->getSession()->getFlashBag()->add('success', 'Vos informations ont été envoyées.');
              return $this->redirectToRoute('fos_user_profile_show');
          }

        return $this->render('HDVUserBundle:Profile:mailci.html.twig', array(
          'form' => $form->createView(),
        ));
      }

      public function editcoordAction(Request $request)
      {
          $user = $this->getUser();

          $form   = $this->get('form.factory')->create(EditCoordType::class, $user);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
             {
              $em = $this->getDoctrine()->getManager();

              $em->flush();

              $request->getSession()->getFlashBag()->add('success', 'Vos coordonnées ont été mises à jour.');
              return $this->redirectToRoute('fos_user_profile_show');
            }

        return $this->render('HDVUserBundle:Profile:editcoord.html.twig', array(
          'form' => $form->createView(),

        ));
      }

      public function mesordresAction($page)
      {
        if ($page < 1) {
          throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $user = $this->getUser();
        $userid = $user->getId();
        $nbPerPage = 30;

        $listOrdres = $this->getDoctrine()
          ->getManager()
          ->getRepository('HDVVentesBundle:Ordres')
          ->getMesOrdres($userid, $page, $nbPerPage)
        ;

        $nbPages = ceil(count($listOrdres) / $nbPerPage);


        if ($page > $nbPages && $page != 1){
          throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }

        return $this->render('HDVUserBundle:Profile:mesordres.html.twig', array(
          'listOrdres' => $listOrdres,
          'nbPages'     => $nbPages,
          'page'        => $page,
        ));
      }

      public function mesestimsAction($page)
      {
        if ($page < 1) {
          throw $this->createNotFoundException("La page ".$page." n'existe pas.");
        }
        $user = $this->getUser();
        $userid = $user->getId();
        $nbPerPage = 10;

        $listEstims = $this->getDoctrine()
          ->getManager()
          ->getRepository('HDVMainBundle:Estimate')
          ->getMesEstims($userid, $page, $nbPerPage)
        ;

        $nbPages = ceil(count($listEstims) / $nbPerPage);


        if ($page > $nbPages && $page != 1) {
          throw $this->createNotFoundException("La page ".$page." n'existe pas.");
       }

        return $this->render('HDVUserBundle:Profile:mesestims.html.twig', array(
          'listEstims' => $listEstims,
          'nbPages'     => $nbPages,
          'page'        => $page,
        ));
      }

}
