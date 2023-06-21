<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Projet;
use App\Entity\SkillTypeEnum;
use App\Entity\User;
use App\Form\ProjetType;
use App\Repository\InscriptionRepository;
use App\Repository\ProjetRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/projets')]
class ProjetController extends AbstractController
{
    #[Route('/', name: 'projets')]
    public function dashboard(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();
        return $this->render('projet/list.twig', [
            'projets' => $projets,
            'roles' => SkillTypeEnum::choices()
        ]);
    }

    #[Route('/mes-projets', name: 'mes_projets')]
    public function mesProjets(ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->getMesProjets($this->getUser());
        return $this->render('projet/list.twig', [
            'projets' => $projets
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProjetRepository $projetRepository, SluggerInterface $slugger): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->isEntrepreneur()) {
            $this->denyAccessUnlessGranted("ROLE_ADMIN");
        }
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('projets_uploads'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $projet->setImage($newFilename);
            }
            $projet->addUser($this->getUser());
            $projetRepository->save($projet, true);

            return $this->redirectToRoute('projets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Projet $projet, ProjetRepository $projetRepository, SluggerInterface $slugger): Response
    {
        if ($projet->getOwner() !== $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('projets_uploads'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $old_image = $projet->getImage();
                if ($old_image) {
                    $file = $this->getParameter('projets_uploads') . "/" . $old_image;
                    if (file_exists($file))
                        unlink($file);
                }
                $projet->setImage($newFilename);
            }
            $projetRepository->save($projet, true);

            return $this->redirectToRoute('projets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}', name: 'app_projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        if ($projet->getOwner() !== $this->getUser()) {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        if ($this->isCsrfTokenValid('delete' . $projet->getId(), $request->request->get('_token'))) {
            $projetRepository->remove($projet, true);
        }

        return $this->redirectToRoute('projets', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/{id}/addUser/{role}', name: 'app_projet_adduser', methods: ['GET'])]
    public function addUser(Request $request, Projet $projet, ProjetRepository $projetRepository, InscriptionRepository $inscriptionRepository, string $role): Response
    {
        $user = $this->getUser();
        $inscription = new Inscription();
        $inscription->setProjet($projet);
        $inscription->setUser($user);
        $inscription->setRole($role);
        $projet->addInscription($inscription);
        $inscriptionRepository->save($inscription, true);
        $projetRepository->save($projet, true);

        $route = $request->headers->get('referer');
        return $this->redirect($route);
    }
}
