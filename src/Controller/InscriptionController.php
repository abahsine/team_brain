<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inscriptions')]
class InscriptionController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/new', name: 'app_inscription_new', methods: ['GET'])]
    public function new(Request $request, InscriptionRepository $inscriptionRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isEtudiant()) {
            $this->denyAccessUnlessGranted("ROLE_ADMIN");
        }
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        return $this->render('inscription/form.html.twig', [
            'inscription' => $inscription,
            'form' => $form->createView(),
        ]);
    }
}
