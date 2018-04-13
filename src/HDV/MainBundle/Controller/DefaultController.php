<?php

namespace HDV\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use HDV\MainBundle\Entity\News;
use HDV\MainBundle\Entity\Estimate;
use HDV\MainBundle\Form\EstimateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HDVMainBundle:Default:index.html.twig');
    }

    public function newsAction()
    {
      $em = $this->getDoctrine()->getManager();

      $listNews = $this
     ->getDoctrine()
     ->getManager()
     ->getRepository('HDVMainBundle:News')
     ->getNewsacc()
   ;

      return $this->render('HDVMainBundle:News:news.html.twig', array(
        'listNews' => $listNews
      ));
    }

    public function carouselAction()
    {
      $em = $this->getDoctrine()->getManager();

      $listRes = $this
     ->getDoctrine()
     ->getManager()
     ->getRepository('HDVVentesBundle:Objects')
     ->getLastResults()
   ;

      return $this->render('HDVMainBundle:Default:carousel.html.twig', array(
        'listRes' => $listRes
      ));
    }


    public function listnewsAction($page)
    {
      if ($page < 1) {
        throw $this->createNotFoundException("La page ".$page." n'existe pas.");
      }

      $nbPerPage = 30;

      $listNews = $this->getDoctrine()
        ->getManager()
        ->getRepository('HDVMainBundle:News')
        ->getNews($page, $nbPerPage)
      ;

      $nbPages = ceil(count($listNews) / $nbPerPage);


      if ($page > $nbPages && $page != 1){
        throw $this->createNotFoundException("La page ".$page." n'existe pas.");
      }

      return $this->render('HDVMainBundle:News:index.html.twig', array(
        'listNews'    => $listNews,
        'nbPages'     => $nbPages,
        'page'        => $page,
      ));
    }


    public function newsviewAction(News $news)
    {

      return $this->render('HDVMainBundle:News:view.html.twig', array(
        'news' => $news
      ));
    }

    public function pagesAction($slug)
    {
      $em = $this->getDoctrine()->getManager();
      $page= $em->getRepository('HDVMainBundle:Pages')->findOneby(array('slug' => $slug));

      if (null === $page) {
        throw new NotFoundHttpException("La page n'existe pas.");
      }

      return $this->render('HDVMainBundle:Default:pages.html.twig', array(
        'page' => $page
      ));
    }

    public function indexestAction(Request $request)
    {

      $estimate = new Estimate();
      $user = $this->getUser();
      $error="";

      $form   = $this->get('form.factory')->create(EstimateType::class, $estimate);


      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
        $files = $form->getData()->getImages();

        $count =count($files);
        if ($count > 3)
        {
          $request->getSession()->getFlashBag()->add('danger', '3 photos maximum par demande, merci.');
          return $this->render('HDVMainBundle:Estimate:index.html.twig', array(
            'form' => $form->createView(), ));

        }


        if($files) {
               $constraints = array('maxSize'=>'3M', 'mimeTypes' => array('image/*'));
               $uploadFiles = $this->get('main.fileuploader')->create($files, $constraints);
           }

           if($uploadFiles->upload()) {
               $estimate->setImages($uploadFiles->getFilePaths());
           } else {
               // If there are file constraint validation issues
               foreach($uploadFiles->getErrors() as $errorq) {
                   $this->get('session')->getFlashBag()->add('danger', $errorq);
               }
               return $this->render('HDVMainBundle:Estimate:index.html.twig', array(
                 'form' => $form->createView(),
               ));
           }

        $em = $this->getDoctrine()->getManager();
        $estimate->setUser($user);
        $em->persist($estimate);
        $em->flush();


        $request->getSession()->getFlashBag()->add('success', 'Votre demande d\'estimation a été enregistrée.');

        return $this->render('HDVMainBundle:Estimate:index.html.twig', array(
          'form' => $form->createView(),
        ));
      }

      return $this->render('HDVMainBundle:Estimate:index.html.twig', array(
        'form' => $form->createView(),
      ));

    }
}
