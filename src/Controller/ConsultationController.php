<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationType;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Personne;
use Dompdf\Dompdf;
use Dompdf\Options;
/**
 * @Route("/consultation")
 */
class ConsultationController extends AbstractController
{
    /**
     * @Route("/", name="consultation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $consultations = $entityManager
            ->getRepository(Consultation::class)
            ->findAll();

        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultations,
        ]);
    }

 /**
     * @Route("/ordonnance", name="ordonnance_list", methods={"GET"})
     */

    public function Ordo(ConsultationRepository $consultationRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $consultations = $consultationRepository->findAll();
      
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('consultation/ordonnance.html.twig', [
            'consultations' => $consultations,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

        return $this->render('consultation/ordonnance.html.twig', [
            'consultations' => $consultations,
        ]);
    }


    /**
     * @Route("/new", name="consultation_new", methods={"GET", "POST"})
     */
    public function new(Request $request)
    {

        $consultation = new Consultation();
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
            $em->persist($consultation);
            $em->flush();

            return $this->redirectToRoute('consultation_index');
        }

        return $this->render('consultation/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_show", methods={"GET"})
     */
    public function show(Consultation $consultation): Response
    {
        return $this->render('consultation/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="consultation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsultationType::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('consultation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consultation/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="consultation_delete", methods={"POST"})
     */
   // public function delete(Request $request, Consultation $consultation, EntityManagerInterface $entityManager): Response
   // {
       // if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->request->get('_token'))) {
          //  $entityManager->remove($consultation);
         //   $entityManager->flush();
      //  }

     //   return $this->redirectToRoute('consultation_index', [], Response::HTTP_SEE_OTHER);
  //  }


     /**
     * @Route("/delete/{id}", name="consultation_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $consultation = $em->getRepository(Consultation::class)->find($id);
        $em->remove($consultation);
        $em->flush();
        return $this->redirectToRoute('consultation_index');
    }
}

