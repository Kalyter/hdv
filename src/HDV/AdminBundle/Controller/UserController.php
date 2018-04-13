<?php

namespace HDV\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use HDV\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
  /**
  * @Security("has_role('ROLE_AUTEUR')")
  */
    public function setvalidateAction(User $userid, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('HDVUserBundle:User')->find($userid);

      if (null === $user) {
        throw new NotFoundHttpException("L'utilisateur n'existe pas.");
      }
      $user->setValidate(3);
      $em->persist($user);
      $em->flush();

      $request->getSession()->getFlashBag()->add('success', 'L\'utilisateur a été validé.');

      return $this->redirectToRoute('hdv_admin_home');

    }



}
