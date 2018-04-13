<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\VentesBundle\Entity\Ventes;
use HDV\VentesBundle\Entity\Ordres;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrdresController extends Controller
{

    public function indexfuturAction()
    {

              $listordres = $this
             ->getDoctrine()
             ->getManager()
             ->getRepository('HDVVentesBundle:Ordres')
             ->getordresfutur()
            ;
              return $this->render('HDVAdminBundle:Ordres:index.html.twig', array(
                  'listordres'           => $listordres,
                ));

    }


    public function indexoldAction()
    {

              $listordres = $this
             ->getDoctrine()
             ->getManager()
             ->getRepository('HDVVentesBundle:Ordres')
             ->getordresold()
            ;
              return $this->render('HDVAdminBundle:Ordres:index.html.twig', array(
                  'listordres'           => $listordres,
                ));

    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ordre = $em->getRepository('HDVVentesBundle:Ordres')->find($id);
        if (null === $ordre) {
            throw new NotFoundHttpException("L'ordre d'id ".$id." n'existe pas.");
        }

          if($request->isXMLHttpRequest())
          {
            $em->remove($ordre);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'L\'ordre a bien été supprimé.');
            return new JsonResponse(array('success' => true));
          }

        return $this->render('HDVAdminBundle:Ordres:delete.html.twig', array(
          'ordre' => $ordre
        ));
    }

    public function validateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ordre = $em->getRepository('HDVVentesBundle:Ordres')->find($id);
        $user = $ordre->getUser();
        if (null === $ordre) {
            throw new NotFoundHttpException("L'ordre d'id ".$id." n'existe pas.");
        }

          if($request->isXMLHttpRequest())
          {
            $ordre->setValidate(true);
            $em->flush();
            $this->get('admin.mailer')->sendOrdreOkMessage($ordre,$user);
            $request->getSession()->getFlashBag()->add('success', 'L\'ordre a bien été validé.');
            return new JsonResponse(array('success' => true));
          }

        return $this->render('HDVAdminBundle:Ordres:validate.html.twig', array(
          'ordre' => $ordre
        ));
    }

    public function demandeciAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ordre = $em->getRepository('HDVVentesBundle:Ordres')->find($id);
        $user = $ordre->getUser();
        if (null === $ordre) {
            throw new NotFoundHttpException("L'ordre d'id ".$id." n'existe pas.");
        }

          if($request->isXMLHttpRequest())
          {
            $message = $request->get('message');
            $this->get('admin.mailer')->sendDemandeCIMessage($ordre,$user,$message);
            $request->getSession()->getFlashBag()->add('success', 'Votre demande a été envoyée par email.');
            return new JsonResponse(array('success' => true));
          }

        return $this->render('HDVAdminBundle:Ordres:demandeci.html.twig', array(
          'ordre' => $ordre
        ));
    }

    public function exportordresAction(){

      //Connexion à la base de données avec le service database_connection
      $conn = $this->get('database_connection');

      //Requête
      $results = $conn->query( "SELECT DISTINCT lastname, firstname, address, city FROM hdv_user INNER JOIN hdv_ordres ON hdv_user.id = hdv_ordres.id_user WHERE hdv_ordres.id_codevac = 7" );

      $response = new StreamedResponse();
      $response->setCallback(function() use($results){

        $handle = fopen('php://output', 'w+');
         // Nom des colonnes du CSV
        fputcsv($handle, array('Nom',
                                 'Prénom',
                                 'Adresse',
                                 'Ville'
                ),';');

        //Champs
        while( $row = $results->fetch() )
           {

                fputcsv($handle,array($row['lastname'],
                                      $row['firstname'],
                                      $row['address'],
                                      $row['city']
                       ),';');

           }

        fclose($handle);
      });


       $response->setStatusCode(200);
       $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
       $response->headers->set('Content-Disposition','attachment; filename="export.csv"');

       return $response;



    }

}
