<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\VentesBundle\Entity\Ventes;
use HDV\VentesBundle\Entity\Objects;
use HDV\VentesBundle\Form\ObjectsType;
use HDV\VentesBundle\Form\ObjectsEditType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\JsonResponse;


class ObjectsController extends Controller
{

  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getManager();

    $vente = $em->getRepository('HDVVentesBundle:Ventes')->find($id);

    if (null === $vente) {
      throw new NotFoundHttpException("La vente n° ".$id." n'existe pas.");
    }
    $this->datatable($id);
  return $this->render('HDVAdminBundle:Objects:index.html.twig', array(
    'vente'           => $vente,
  ));
  }

  private function datatable($id)
{
    return $this->get('datatable')
                ->setEntity("HDVVentesBundle:Objects", "o")                          // replace "XXXMyBundle:Entity" by your entity
        ->setDatatableId('d21')
                ->setFields(
                        array(
                            "ID"          => 'o.id',
                            "Ordre"       => 'o.ordre',
                            "Description"          => 'o.description',                        // Declaration for fields:
                            "Estimations"       => 'o.estimbasse',                     // "label" => "alias.field_attribute_for_dql"
                            "Actions"   => 'o.id',
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
          3 => array(
              'view' => 'HDVVentesBundle:Default:actions2.html.twig', // Path to the template
          ),
          4 => array(
              'view' => 'HDVAdminBundle:Objects:actions.html.twig', // Path to the template
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

    public function importAction(Request $request, $id)
    {
      $em = $this->getDoctrine()->getManager();

      $vente = $em->getRepository('HDVVentesBundle:Ventes')->find($id);

      if (null === $vente) {
        throw new NotFoundHttpException("La vente n° ".$id." n'existe pas.");
      }

      $defaultData = array('message' => 'Type your message here');
      $form = $this->createFormBuilder($defaultData)
       ->add('filecsv', FileType::class)
       ->add('send', SubmitType::class)
       ->getForm();

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
      $filename = $form->get('filecsv')->getData();
       $converter = $this->container->get('import.csvtoarray');
       $data = $converter->convert($filename, "\t");


       // Define the size of record, the frequency for persisting the data and the current index of records
       $size = count($data);
       $batchSize = 599;
       $i = 1;
      $request->getSession()->getFlashBag()->add('success', 'Importation du fichier csv réussi.');
       // Processing on each row of data
       foreach($data as $row) {

           $obj = New Objects();
    // Updating info
$fam = $em->getRepository('HDVVentesBundle:Famille')->findOneBy(array('ite' => $row['famille']));

           $obj->setCodevac($vente);
           $obj->setCodedossier($row['codedossier']);
           $obj->setOrdre($row['ordre']);
           $obj->setOrdrebis($row['bis']);
           $obj->setDescription($row['description']);
           $obj->setEstimbasse($row['estb']);
           $obj->setEstimhaute($row['esth']);
           $obj->setFamille($fam);

       $obj->setImage($row['image']);
    // Persisting the current user
           $em->persist($obj);

    // Each 20 users persisted we flush everything
           if (($i % $batchSize) === 0) {

               $em->flush();
      // Detaches all objects from Doctrine for memory save
               $em->clear();

           }

           $i++;

       }

  // Flushing and clear data on queue
       $em->flush();
       $em->clear();
       $this->datatable($id);
       return $this->render('HDVAdminBundle:Objects:index.html.twig', array(
         'vente'           => $vente,
       ));
     }

    return $this->render('HDVAdminBundle:Objects:import.html.twig', array(
      'vente'           => $vente,
      'form' => $form->createView(),
    ));

    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    public function addobjectAction(Ventes $vente, Request $request)
    {
      $object = new Objects();
      $form   = $this->get('form.factory')->create(ObjectsType::class, $object);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $object->setCodevac($vente);
        $em->persist($object);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Le lot a bien été enregistré.');

        return $this->redirectToRoute('hdv_admin_objects_edit', array('object' => $object->getId()));
      }

      return $this->render('HDVAdminBundle:Objects:add.html.twig', array(
        'form' => $form->createView(),
        'vente' => $vente,

      ));
    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    public function editobjectAction(Objects $object, Request $request)
    {

      $form   = $this->get('form.factory')->create(ObjectsEditType::class, $object);
      $vente = $object->getCodevac();

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($object);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Le lot a bien été modifié.');

        return $this->redirectToRoute('hdv_admin_objects_vente', array('id' => $vente));
      }

      return $this->render('HDVAdminBundle:Objects:edit.html.twig', array(
        'vente' => $vente,
        'object' => $object,
        'form' => $form->createView(),

      ));
    }

    public function reqdossierAction($dossier)
    {
      if($dossier == "0")
      {
      $usern = '';
      }
      else
      {
        $em = $this->getDoctrine()->getManager();
        $codeuser = $em->getRepository('HDVUserBundle:User')->findOneBy(array ('codedossier' => $dossier));

        if($codeuser)
        {
          $usern = 'Vendeur : '.$codeuser->getGender().' '.$codeuser->getFirstname().' '.$codeuser->getLastname();
        }
        else {
          $usern = 'Vendeur non enregistré';
        }
      }


      $response = new JsonResponse();
      return $response->setData(array ('nom' => $usern));

    }

    public function picturesAction(Objects $object)
    {
          $idvente = $object->getCodevac()->getId();
          $em = $this->getDoctrine()->getManager();
          $picatt = array();
          $imgsupp = array();
          $req = $em->getRepository('HDVVentesBundle:Objects')->findBy(array('codevac' => $idvente));

          foreach ($req as $objecti) {
           $picatt[] = $objecti->getImage();
           $var = $objecti->getImagesupp();
           if(isset($var))
           {
             $imgs = explode("\n", $var);
             $imgsupp = array_merge($imgsupp,$imgs);
           }
          }

            $path = 'bundles/images/ventes/'.$idvente;
           $pictures = array_diff(scandir($path), array('..', '.'), $picatt, $imgsupp);
              return $this->render('HDVAdminBundle:Objects:pictures.html.twig', array(
                  'object'           => $object,
                  'pictures' => $pictures,
                ));


    }

    public function deleteAction(Objects $object)
    {

      if (!$object) {
             throw $this->createNotFoundException('No object found');
          }

          $em = $this->getDoctrine()->getEntityManager();
          $vente = $object->getCodevac();
          $em->remove($object);
          $em->flush();

        return $this->redirectToRoute('hdv_admin_objects_vente', array('id' => $vente));


    }

    public function updatepicturesAction(Objects $object, $from, $value, $section)
    {
      $em = $this->getDoctrine()->getManager();
      $imgsupp = $object->getImagesupp();

      if($from == "nonatt")
      {

        if($section == "supplementaire")
        {
          if($imgsupp == null)
          {
          $imgsuppok = $value;
          }
          else
          {
          $imgsuppok = $value."\n".$imgsupp;
          }
          $object->setImagesupp($imgsuppok);
        }
        else if($section == "principal")
        {
          $object->setImage($value);
        }

      }
      else if($from == "multiple")
      {

        if($section == "principal")
        {
          $object->setImage($value);

          $newsupp = str_replace($value."\n", "", $imgsupp,$count);

              if($count == 0)
              {
                $newsupp = str_replace("\n".$value, "", $imgsupp, $count2);
                if($count2 == 0)
                {
                  $newsupp = str_replace($value, "", $imgsupp);
                }
              }

          if($newsupp == ""){$newsupp=null;}

          $object->setImagesupp($newsupp);

        }
        else if ($section == "base2")
        {
          $newsupp = str_replace($value."\n", "", $imgsupp,$count);

              if($count == 0)
              {
                $newsupp = str_replace("\n".$value, "", $imgsupp, $count2);
                if($count2 == 0)
                {
                  $newsupp = str_replace($value, "", $imgsupp);
                }
              }

          if($newsupp == ""){$newsupp=null;}
          $object->setImagesupp($newsupp);
        }

      }
      else if($from == "principal")
      {

        if($section == "supplementaire")
        {
          if($imgsupp == null)
          {
          $imgsuppok = $value;
          }
          else
          {
          $imgsuppok = $value."\n".$imgsupp;
          }

          $object->setImagesupp($imgsuppok);
          $object->setImage(null);
        }
        else if($section == "base2")
        {
          $object->setImage(null);
        }

      }
      $em->persist($object);
      $em->flush();
      return new JsonResponse(array('success' => true));
    }

}
