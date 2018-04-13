<?php
namespace HDV\AdminBundle\Services;

use Symfony\Component\Templating\EngineInterface;

class Mailer
{
    protected $mailer;
    protected $templating;
    private $from = "contact@enghien-svv.com";
    private $reply = "contact@enghien-svv.com";
    private $name = "Hotel des ventes d'Enghien";

    public function __construct($mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    protected function sendMessage($to, $subject, $body)
    {
        $mail = \Swift_Message::newInstance();

        $mail
        ->setFrom($this->from,$this->name)
        ->setTo($to)
        ->setCC($this->from)
        ->setSubject($subject)
        ->setBody($body)
        ->setReplyTo($this->reply,$this->name)
        ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    public function sendOrdreOkMessage(\HDV\VentesBundle\Entity\Ordres $ordre, \HDV\UserBundle\Entity\User $user)
    {
        $subject = "Votre ordre d'achat a été validé.";
        $template = 'HDVAdminBundle:Ordres:mail_content.html.twig';
        $to = $user->getEmail();
        $body = $this->templating->render($template, array('ordres' => $ordre));
        $this->sendMessage($to, $subject, $body);
    }

    public function sendDemandeCIMessage(\HDV\VentesBundle\Entity\Ordres $ordre, \HDV\UserBundle\Entity\User $user, $message)
    {
        $subject = "Demande d'une pièce d'identitée.";
        $template = 'HDVAdminBundle:Ordres:mail_demande_content.html.twig';
        $to = $user->getEmail();
        $body = $this->templating->render($template, array('ordres' => $ordre,'message' => $message));
        $this->sendMessage($to, $subject, $body);
    }

    public function sendEnquiryAnswerMessage(\HDV\VentesBundle\Entity\Enquiry $enquiry, $email, $message)
    {
        $subject = "Réponse à votre demande de renseignements.";
        $template = 'HDVAdminBundle:Enquiry:mail_answer.html.twig';
        $to = $email;
        $body = $this->templating->render($template, array('enquiry' => $enquiry,'message' => $message));
        $this->sendMessage($to, $subject, $body);
    }

    public function sendEstimateAnswerMessage(\HDV\MainBundle\Entity\Estimate $estimate, $email, $message)
    {
        $subject = "Réponse à votre demande d'estimation.";
        $template = 'HDVAdminBundle:Estimate:mail_answer.html.twig';
        $to = $email;
        $body = $this->templating->render($template, array('estimate' => $estimate,'message' => $message));
        $this->sendMessage($to, $subject, $body);
    }
}
