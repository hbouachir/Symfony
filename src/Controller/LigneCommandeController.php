<?php

namespace App\Controller;

use App\Entity\Lignecommande;
use App\Form\LigneCommandeType;
use App\Repository\LigneCommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ligne/commande")
 */
class LigneCommandeController extends AbstractController
{
    /**
     * @Route("/{idCommande}", name="ligne_commande_index",methods={"GET","POST"})
     */
    public function index(LigneCommandeRepository $ligneCommandeRepository,$idCommande): Response
    {
        return $this->render('ligne_commande/index.html.twig', [
            'ligne_commandes' => $ligneCommandeRepository->findBy(array('commande'=>$idCommande)),
        ]);
    }

    /**
     * @Route("/new", name="ligne_commande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ligneCommande = new Lignecommande();
        $form = $this->createForm(LigneCommandeType::class, $ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ligneCommande);
            $entityManager->flush();

            return $this->redirectToRoute('ligne_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_commande/new.html.twig', [
            'ligne_commande' => $ligneCommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_commande_show", methods={"GET"})
     */
    public function show(Lignecommande $ligneCommande): Response
    {
        return $this->render('ligne_commande/show.html.twig', [
            'ligne_commande' => $ligneCommande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ligne_commande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lignecommande $ligneCommande): Response
    {
        $form = $this->createForm(LigneCommandeType::class, $ligneCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ligne_commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ligne_commande/edit.html.twig', [
            'ligne_commande' => $ligneCommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ligne_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Lignecommande $ligneCommande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneCommande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ligneCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ligne_commande_index', [], Response::HTTP_SEE_OTHER);
    }



}
