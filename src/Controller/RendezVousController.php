<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/rendez")
 */
class RendezVousController extends AbstractController
{
    /**
     * @Route("/", name="rendez_vous_index", methods={"GET"})
     */
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        $client = $this->getDoctrine() 
            ->getRepository(Personne::class)
            ->find(1);
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findBy(array('idClient'=>$client)),
        ]);
    }

    /**
     * @Route("/new", name="rendez_vous_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    
    {
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);
        $client = $this->getDoctrine()
            ->getRepository(Personne::class)
            ->find(1);
        $medecin = $this->getDoctrine()
            ->getRepository(Personne::class)
            ->find(2);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezVou->setBackgroundColor("#d41616");
            $rendezVou->setTextColor("#000000");
            $rendezVou->setBorderColor("#060505");
            $rendezVou->setIdClient($client);
            $rendezVou->setIdMedecin($medecin);
            $entityManager->persist($rendezVou);
            $entityManager->flush();
    
              $email = (new Email())
                ->from('nourhenekh20@gmail.com')
               ->to('sirina.belhassen@gmail.com')
               // //->cc('cc@example.com')
               // //->bcc('bcc@example.com')
              //  //->replyTo('fabien@example.com')
              //  //->priority(Email::PRIORITY_HIGH)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html('<p>https://meet.google.com/vxe-csyq-cdd?pli=1</p>');

           $mailer->send($email);

            return $this->redirectToRoute('rendez_vous_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->render('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rendez_vous_show", methods={"GET"})
     */
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }


    /**
     * @Route("/{id}/editrendezvous", name="rendez_edit", methods={"PUT"})
     */
    public function majEvent(Request $request, ?RendezVous $rendezVous): Response
    {

        $donnees =json_decode($request->getContent());

        if (isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->end) && !empty($donnees->end) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)&&
            isset($donnees->email) && !empty($donnees->email)
           ){

            $code = 200 ;
            if(!$rendezVous){
                $rendezVous = new RendezVous();
                $code = 201;
            }

            $rendezVous->setTitle($donnees->title);
            $rendezVous->setStart(new \DateTime($donnees->start));
            $rendezVous->setEnd(new \DateTime($donnees->end));
            $rendezVous->setDescription($donnees->description);
            $rendezVous->setBorderColor($donnees->borderColor);
            $rendezVous->setTextColor($donnees->textColor);
            $rendezVous->setBackgroundColor($donnees->backgroundColor);
            $rendezVous->setEmail($donnees->email);
            $em = $this->getDoctrine()->getManager();
            $em->persist($rendezVous);
            $em->flush();

            return new Response('ok',$code);

        }

        else{
            return new Response('donnees incompléte',404);
        }

    }



    /**
     * @Route("/{id}/edit", name="rendez_vous_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="rendezvous_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $rd = $em->getRepository(RendezVous::class)->find($id);
        $em->remove($rd);
        $em->flush();
        return $this->redirectToRoute('rendez_vous_index');
    }

    

}
