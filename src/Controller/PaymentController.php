<?php

namespace App\Controller;

use App\Form\PaymentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PaymentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Personne;
use App\Entity\nomRecherche;
use App\Form\nomRechercheType;



use App\Entity\Payment;


class PaymentController extends AbstractController
{
  
    
      /**
       * @param PaymentRepository $repository
     * @return Response
     *@Route("/affiche",name="payment_list")
     */
   public  function AffichePayment( PaymentRepository $repository){
    $payment = $repository -> findAll();
    return  $this->render('payment/index.html.twig',['paymentt' => $payment]);  
        
}
    /**
     * @Route("/homee", name="payment")
     */
    public function index(): Response
    {
        return $this->render('/templateHTML/home.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
        /**
     * @Route("/paypal", name="paypal")
     */
    public function paypal(): Response
    {
        return $this->render('/payment/paypal.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
        /**
     * @Route("/chekout", name="chekout")
     */
    public function chek(): Response
    {
        return $this->render('/templateHTML/checkout.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
/**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
   * @Route("/payment/new", name="new_payment")
     */
 
    public function new(Request $request) {
        $payment = new Payment();
        $form = $this->createForm( PaymentType :: class , $payment)   ;  
       
       
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
        
  
          $em = $this->getDoctrine()->getManager();
          $em->persist($payment);
          $em->flush();
  
          return $this->redirectToRoute('payment_list');
        }
        return $this->render('payment/new.html.twig',['form' => $form->createView()]);
    }
         /**
     * @Route("/payment/{id}", name="payment_show")
     */
    public function show($id) {
      $payment = $this->getDoctrine()->getRepository(Payment::class)->find($id);

      return $this->render('payment/show.html.twig', array('payment' => $payment));
    }

     /**
     * @Route("/payment/edit/{id}", name="edit_payment")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
      $payment = new Payment();
      $payment = $this->getDoctrine()->getRepository(payment::class)->find($id);

      $form = $this->createFormBuilder($payment)
      ->add('numeroCompte')
        ->add('password')
        ->add('dateExpiration')
        ->add('civilite')
        ->add('personne',EntityType::class,
          ['class'=>Personne::class,
              'choice_label'=>'nom'])
        ->add('save', SubmitType::class, array(
          'label' => 'Modifier'         
        ))->getForm();

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('payment_list');
      }

      return $this->render('payment/edit.html.twig', ['form' => $form->createView()]);
    }

 /**
   * @Route("/payment/delete/{id}",name="delete_payment")
   * @Method({"DELETE"})
   */
  public function delete(Request $request, $id) {
      $payment = $this->getDoctrine()->getRepository(Payment::class)->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($payment);
      $entityManager->flush();

      $response = new Response();
      $response->send();

      return $this->redirectToRoute('payment_list');
    }
     /**
     * @Route("/art_cat/", name="article_par_cat")
     * Method({"GET", "POST"})
     */
    public function articlesParCategorie(Request $request) {
      $nomRecherche = new nomRecherche();
      $form = $this->createForm(nomRechercheType::class,$nomRecherche);
      $form->handleRequest($request);

      $payment= [];

      if($form->isSubmitted() && $form->isValid()) {
        $nom = $nomRecherche->getNom();
       
        if ($nom!="") 
        {
          
         
         $payment= $this->getDoctrine()->getRepository(Payment::class)->findBy(['nom' => $nom] );
        }
        else   
          $payment= $this->getDoctrine()->getRepository(Payment::class)->findAll();
        }
      
      return $this->render('payment/paymentParnom.html.twig',['form' => $form->createView(),'payments' => $payment]);
      }
  
  

     

}
