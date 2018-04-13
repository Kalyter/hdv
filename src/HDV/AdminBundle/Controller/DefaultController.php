<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\VentesBundle\Entity\Ventes;
use HDV\VentesBundle\Entity\Image;
use HDV\VentesBundle\Form\VentesType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
  /**
  * @Security("has_role('ROLE_AUTEUR')")
  */
    public function indexpanelAction()
    {

  return $this->render('HDVAdminBundle:Default:panel.html.twig');

    }

  /**
  * @Security("has_role('ROLE_AUTEUR')")
  */
    public function indexAction($period)
    {

      $this->datatable($period);
  return $this->render('HDVAdminBundle:Ventes:index.html.twig', array(
      'period'           => $period,
    ));

    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    public function addventesAction(Request $request)
    {
      $vente = new Ventes();
      $form   = $this->get('form.factory')->create(VentesType::class, $vente);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($vente);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'La vente a bien été enregistrée.');

        return $this->redirectToRoute('hdv_ventes_view', array('id' => $vente->getId()));
      }

      return $this->render('HDVAdminBundle:Ventes:add.html.twig', array(
        'form' => $form->createView(),

      ));
    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    public function editventesAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $vente = $em->getRepository('HDVVentesBundle:Ventes')->find($id);

      if (null === $vente) {
        throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }

      $form   = $this->get('form.factory')->create(VentesType::class, $vente);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($vente);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'La vente a bien été modifié.');

        return $this->redirectToRoute('hdv_admin_ventes_home', array(
          'period' => 'futur',

        ));
      }

      return $this->render('HDVAdminBundle:Ventes:edit.html.twig', array(
        'vente' => $vente,
        'form' => $form->createView(),

      ));
    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    private function datatable($period)
  {
    $datenow=new \Datetime('now');
      if($period == "old")
      {

        return $this->get('datatable')
                    ->setEntity("HDVVentesBundle:Ventes", "v")                          // replace "XXXMyBundle:Entity" by your entity
                    ->setDatatableId('d17')
                    ->setFields(
                            array(
                    "ID"          => 'v.id',
                    "Date"       => 'v.date',
                                "Title"          => 'v.title',                        // Declaration for fields:
                                "Catalogue"       => 'v.catpublished',
                                "Actions" => 'v.id',
                                "_identifier_"  => 'v.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
                            )
                    ->setSearch(true)
                    ->setWhere(                                // set your dql where statement
                     'v.date < :datecourante',
                     array('datecourante' => $datenow)
                )
                    ->setOrder("v.date", "desc")
                    ->setRenderers(
          array(
              1 => array(
                  'view' => 'HDVAdminBundle:Default:actions.html.twig', // Path to the template
              ),
              3 => array(
                  'view' => 'HDVAdminBundle:Default:actions0.html.twig', // Path to the template
              ),
              4 => array(
                  'view' => 'HDVAdminBundle:Default:actions1.html.twig', // Path to the template
              ),
          )
  );
      }
      else
      {
        return $this->get('datatable')
                    ->setEntity("HDVVentesBundle:Ventes", "v")                          // replace "XXXMyBundle:Entity" by your entity
                    ->setDatatableId('d17')
                    ->setFields(
                            array(
                    "ID"          => 'v.id',
                    "Date"       => 'v.date',
                                "Title"          => 'v.title',                        // Declaration for fields:
                                "Catalogue"       => 'v.catpublished',
                                "Actions" => 'v.id',
                                "_identifier_"  => 'v.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
                            )
                    ->setSearch(true)
                    ->setWhere(                                // set your dql where statement
                     'v.date > :datecourante',
                     array('datecourante' => $datenow)
                )
                    ->setOrder("v.date", "desc")
                    ->setRenderers(
          array(
              1 => array(
                  'view' => 'HDVAdminBundle:Default:actions.html.twig', // Path to the template
              ),
              3 => array(
                  'view' => 'HDVAdminBundle:Default:actions0.html.twig', // Path to the template
              ),
              4 => array(
                  'view' => 'HDVAdminBundle:Default:actions1.html.twig', // Path to the template
              ),
          )
  );
      }


  }

  /**
   * Grid action
   * @return Response
   */
    public function gridAction($period)
  {
      return $this->datatable($period)->execute();                                      // call the "execute" method in your grid action
  }


}
