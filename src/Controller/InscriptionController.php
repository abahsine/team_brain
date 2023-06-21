<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Projet;
use App\Entity\SkillTypeEnum;
use App\Entity\User;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/roles', name: 'show_roles', methods: ['GET'])]
    public function roles(Request $request, Projet $projet): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isEtudiant()) {
            $this->denyAccessUnlessGranted("ROLE_ADMIN");
        }

        $roles = new ArrayCollection(SkillTypeEnum::choices());
        $inscriptions = $projet->getInscriptions();
        foreach ($inscriptions as $inscription) {
            $role = $inscription->getRole();
            if ($roles->contains($role)) {
                $roles->removeElement($role);
            }
        }

        $skills = $user->getSkills();
        $frontend = false;
        $backend = false;
        $fullstack = false;
        foreach ($skills as $skill) {
            if ($skill->getType() === SkillTypeEnum::Frontend->name) {
                $frontend = true;
            }
            if ($skill->getType() === SkillTypeEnum::Backend->name) {
                $backend = true;
            }
            if ($skill->getType() === SkillTypeEnum::Fullstack->name) {
                $fullstack = true;
            }
        }

        if ($backend && $frontend)
            $fullstack = true;

        if (!$fullstack)
            $roles->removeElement(SkillTypeEnum::Fullstack->name);
        if (!$backend)
            $roles->removeElement(SkillTypeEnum::Backend->name);
        if (!$frontend)
            $roles->removeElement(SkillTypeEnum::Frontend->name);

        return new JsonResponse($roles->toArray());
    }
}
