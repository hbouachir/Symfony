<?php

namespace App\Controller;
 

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FactureRepository;

use App\Form\FactureType;
use App\Entity\Facture;
;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class FactureController extends AbstractController
{
     /**
     * @Route("/admin", name="admin")
     */
    public function admin(): Response
    {
        return $this->render('AdminTemplate/dashboard.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }
    /**
     * @Route("/facture", name="facture")
     */
    public function index(): Response
    {
        return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }
          /**
       * @param FactureRepository $repository
     * @return Response
     *@Route("/afficheFacture",name="facture_list")
     */
   public  function AfficheFacture( FactureRepository $repository){
    $facture = $repository -> findAll();
    return  $this->render('facture/index.html.twig',['facturee' => $facture]);  
        
}
  
/**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
   * @Route("/facture/new", name="new_facture")
     */
 
    public function new(Request $request) {
        $facture = new Facture();
        $form = $this->createForm( FactureType :: class , $facture)   ;  
       
       
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
        
  
          $em = $this->getDoctrine()->getManager();
          $em->persist($facture);
          $em->flush();
  
          return $this->redirectToRoute('facture_list');
        }
        return $this->render('facture/ajout.html.twig',['form' => $form->createView()]);
    }
    /**
   * @Route("/facture/delete/{id}",name="delete_facture")
   * @Method({"DELETE"})
   */
  public function delete(Request $request, $id) {
    $facture = $this->getDoctrine()->getRepository(Facture::class)->find($id);

    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($facture);
    $entityManager->flush();

    $response = new Response();
    $response->send();

    return $this->redirectToRoute('facture_list');
  }
  
}
