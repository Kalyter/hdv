<?php

namespace HDV\VentesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Waldo\DatatableBundle\Util\Datatable;
use Symfony\Component\HttpFoundation\JsonResponse;
use HDV\VentesBundle\Entity\Ordres;

class DefaultController extends Controller
{
    public function indexAction()
    {

      $listVentes = $this
     ->getDoctrine()
     ->getManager()
     ->getRepository('HDVVentesBundle:Ventes')
     ->getVentesfutur()
   ;


        return $this->render('HDVVentesBundle:Ventes:index.html.twig', array(
          'listVentes' => $listVentes
        ));
    }

    public function oldventesAction()
    {

      $listVentes = $this
     ->getDoctrine()
     ->getManager()
     ->getRepository('HDVVentesBundle:Ventes')
     ->getVentesold()
   ;


        return $this->render('HDVVentesBundle:Ventes:old.html.twig', array(
          'listVentes' => $listVentes
        ));
    }


    public function menuAction()
    {
      $em = $this->getDoctrine()->getManager();

      $listVentes = $this
     ->getDoctrine()
     ->getManager()
     ->getRepository('HDVVentesBundle:Ventes')
     ->getVentesfuturmenu()
   ;

      return $this->render('HDVVentesBundle:Ventes:menu.html.twig', array(
        'listVentes' => $listVentes
      ));
    }

    public function includeAction()
    {
      $em = $this->getDoctrine()->getManager();

      $listVentes = $this
     ->getDoctrine()
     ->getManager()
     ->getRepository('HDVVentesBundle:Ventes')
     ->getVentesfuturmenu()
   ;

      return $this->render('HDVVentesBundle:Ventes:include.html.twig', array(
        'listVentes' => $listVentes
      ));
    }


    public function viewAction($id)
    {
      $em = $this->getDoctrine()->getManager();

      $vente = $em->getRepository('HDVVentesBundle:Ventes')->find($id);

      if (null === $vente) {
        throw new NotFoundHttpException("La vente n° ".$id." n'existe pas.");
      }
      $this->datatable($id);
    return $this->render('HDVVentesBundle:Ventes:view.html.twig', array(
      'vente'           => $vente,
    ));
    }


    public function viewobjectAction($id)
    {
      $em = $this->getDoctrine()->getManager();

      $object = $em->getRepository('HDVVentesBundle:Objects')->find($id);

      if (null === $object) {
        throw new NotFoundHttpException("L'objet n° ".$id." n'existe pas.");
      }

    return $this->render('HDVVentesBundle:Objects:view.html.twig', array(
      'object'           => $object,
    ));
    }

    public function plusAction($id)
    {
      $em = $this->getDoctrine()->getManager();

      $vente = $em->getRepository('HDVVentesBundle:Ventes')->find($id);

      if (null === $vente) {
        throw new NotFoundHttpException("La vente n° ".$id." n'existe pas.");
      }
      $this->datatable($id);
    return $this->render('HDVVentesBundle:Ventes:plus.html.twig', array(
      'vente'           => $vente,
    ));
    }

    public function catAction($id)
    {
      $em = $this->getDoctrine()->getManager();

      $vente = $em->getRepository('HDVVentesBundle:Ventes')->find($id);

      if (null === $vente) {
        throw new NotFoundHttpException("La vente n° ".$id." n'existe pas.");
      }

      $listObjects = $em
        ->getRepository('HDVVentesBundle:Objects')
        ->findBy(array('codevac' => $id), array('ordre' => 'ASC'))
      ;


      return $this->render('HDVVentesBundle:Ventes:catalogue.html.twig', array(
       'vente'           => $vente,
       'listObjects' => $listObjects,
     ));
    }


    private function datatable($id)
  {
      return $this->get('datatable')
                  ->setEntity("HDVVentesBundle:Objects", "o")                          // replace "XXXMyBundle:Entity" by your entity
  				->setDatatableId('d10')
                  ->setFields(
                          array(
  						    "Illustration"          => 'o.image',
                  "Ordre"       => 'o.ordre',
                              "Description"          => 'o.description',                        // Declaration for fields:
                              "Estimations"       => 'o.estimbasse',                     // "label" => "alias.field_attribute_for_dql"
                              ""   => 'o.estimhaute',      // Use SQL commands, you must always define an alias
                              ""   => 'o.imagesupp',
                              ""   => 'o.ordrebis',
                              "_identifier_"  => 'o.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
                          )
                          ->setWhere(                                // set your dql where statement
     'o.codevac = :codev',
     array('codev' => $id)
)
  				->setSearch(true)

                  ->setOrder("o.ordre", "asc")
                  ->setRenderers(
        array(
            0 => array(
                'view' => 'HDVVentesBundle:Default:actions.html.twig', // Path to the template
            ),
            1 => array(
                'view' => 'HDVVentesBundle:Default:actions1.html.twig', // Path to the template
            ),
            2 => array(
                'view' => 'HDVVentesBundle:Default:actions0.html.twig', // Path to the template
            ),
            3 => array(
                'view' => 'HDVVentesBundle:Default:actions2.html.twig', // Path to the template
            ),
        )
);
  				                             // it's also possible to set the default order
  }

  /**
   * Grid action
   * @return Response
   */
  	public function gridAction($id)
  {
      return $this->datatable($id)->execute();                                      // call the "execute" method in your grid action
  }



}
