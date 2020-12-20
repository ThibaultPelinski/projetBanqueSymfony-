<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Target;
use App\Form\TargetType;
use App\Repository\TargetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/target")
 */
class TargetController extends AbstractController
{
    /**
     * @Route("/", name="target_index", methods={"GET"})
     */
    public function index(TargetRepository $targetRepository, UserInterface $user): Response
    {
        $id = $user->id;
        $user = $this->getUser();
        $roles = $user->getRoles();
        if ($roles[0] == 'ROLE_ADMIN') {
        return $this->render('target/index.html.twig', [
            'targets' => $targetRepository->findAll(),
        ]);
        } else {
            return $this->render('target/index.html.twig', [
                'targets' => $targetRepository->findBy(["user" => $id]),
                'role'=>$roles[0]
            ]);
        }
    }

    /**
     * @Route("/new", name="target_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $target = new Target();
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($target);
            $entityManager->flush();

            return $this->redirectToRoute('target_index');
        }

        return $this->render('target/new.html.twig', [
            'target' => $target,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="target_show", methods={"GET"})
     */
    public function show(Target $target): Response
    {
        return $this->render('target/show.html.twig', [
            'target' => $target,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="target_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Target $target): Response
    {
        $form = $this->createForm(TargetType::class, $target);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('target_index');
        }

        return $this->render('target/edit.html.twig', [
            'target' => $target,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="target_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Target $target): Response
    {
        if ($this->isCsrfTokenValid('delete'.$target->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($target);
            $entityManager->flush();
        }

        return $this->redirectToRoute('target_index');
    }
}
