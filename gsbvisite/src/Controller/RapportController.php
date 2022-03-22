<?php

namespace App\Controller;

use App\Entity\Rapport;
use App\Form\RapportType;
use App\Repository\OffrirRepository;
use App\Repository\RapportRepository;
use App\Repository\VisiteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rapport")
 */
class RapportController extends AbstractController
{
    /**
     * @Route("/", name="rapport_index", methods={"GET"})
     */
    public function index(RapportRepository $rapportRepository): Response
    {
        $request = Request::createFromGlobals();
        $query = $request->query->get('date');
        $loggedUser = $this->getUser();


        // verifie la date si est pas nul
        if ($query != '' && $query != Null && strtotime($query)) {
            $rapports = $rapportRepository->findRapportByDate(date_create($query));
        } else { //sinon on affiche les rapports du visiteur
            $rapports = $rapportRepository->findBy(['visiteur' => $loggedUser]);
        }
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapports
        ]);
    }
    /*    $visiteurConnecter = $this->getUser();
        return $this->render('rapport/index.html.twig', [
            'rapports' => $rapportRepository->findBy(['visiteur' => $visiteurConnecter]),
        ]);*/


    /**
     * @Route("/new", name="rapport_new", methods={"GET","POST"})
     */
    public function new(Request $request, VisiteurRepository $visiteurRepository, OffrirRepository $offrirRepository): Response
    {
        $rapport = new Rapport();
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visiteurConnecte = $this->getUser();
            $visiteur = $visiteurRepository->findOneBy(['login' => $visiteurConnecte->getUserIdentifier()]);
            $rapport->setVisiteur($visiteur);

            $offrir = $offrirRepository->findAll();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rapport);
            $entityManager->flush();

            return $this->redirectToRoute('rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/new.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="rapport_show", methods={"GET"})
     */
    public function show(Rapport $rapport): Response
    {
        return $this->render('rapport/show.html.twig', [
            'rapport' => $rapport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rapport_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rapport $rapport): Response
    {
        $form = $this->createForm(RapportType::class, $rapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rapport_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rapport/edit.html.twig', [
            'rapport' => $rapport,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="rapport_delete", methods={"POST"})
     */
    public function delete(Request $request, Rapport $rapport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rapport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rapport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rapport_index', [], Response::HTTP_SEE_OTHER);
    }
}
