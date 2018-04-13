<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\MainBundle\Entity\News;
use HDV\MainBundle\Entity\Image;
use HDV\MainBundle\Form\NewsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{


  /**
  * @Security("has_role('ROLE_AUTEUR')")
  */
    public function indexAction()
    {

      $this->datatable();
  return $this->render('HDVAdminBundle:News:index.html.twig');

    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    public function addnewsAction(Request $request)
    {
      $news = new News();
      $form   = $this->get('form.factory')->create(NewsType::class, $news);

      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($news);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'L\'annonce a bien été enregistrée.');

        return $this->redirectToRoute('hdv_admin_news_home');
      }

      return $this->render('HDVAdminBundle:News:add.html.twig', array(
        'form' => $form->createView(),

      ));
    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    public function editnewsAction(News $news, Request $request)
    {
      $form   = $this->get('form.factory')->create(NewsType::class, $news);


      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($news);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'L\'annonce a bien été modifiée.');

        return $this->redirectToRoute('hdv_admin_news_home');
      }

      return $this->render('HDVAdminBundle:News:edit.html.twig', array(
        'news' => $news,
        'form' => $form->createView(),

      ));
    }

    public function deletenewsAction(News $news)
    {

      if (!$news) {
             throw $this->createNotFoundException('No news found');
          }

          $em = $this->getDoctrine()->getEntityManager();
          $em->remove($news);
          $em->flush();

      return $this->redirectToRoute('hdv_admin_news_home');
    }

    /**
    * @Security("has_role('ROLE_AUTEUR')")
    */
    private function datatable()
    {

        return $this->get('datatable')
                    ->setEntity("HDVMainBundle:News", "n")                          // replace "XXXMyBundle:Entity" by your entity
                    ->setDatatableId('n1')
                    ->setFields(
                            array(
                    "ID"          => 'n.id',
                    "Date"       => 'n.date',
                                "Title"          => 'n.title',                        // Declaration for fields:
                                "Publié"       => 'n.published',
                                "Actions" => 'n.id',
                                "_identifier_"  => 'n.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
                            )
                    ->setSearch(true)
                    ->setOrder("n.date", "desc")
                    ->setRenderers(
          array(
              1 => array(
                  'view' => 'HDVAdminBundle:Default:actions.html.twig', // Path to the template
              ),
              3 => array(
                  'view' => 'HDVAdminBundle:Default:actions0.html.twig', // Path to the template
              ),
              4 => array(
                  'view' => 'HDVAdminBundle:News:actions.html.twig', // Path to the template
              ),
          )
  );


  }

  /**
   * Grid action
   * @return Response
   */
    public function gridAction()
  {
      return $this->datatable()->execute();                                      // call the "execute" method in your grid action
  }


}
