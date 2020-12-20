<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Account;
use App\Form\AccountType;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * @Route("/account")
 */
class AccountController extends AbstractController
{

    /**
     * @Route("/", name="account_index", methods={"GET"})
     */
    public function index(AccountRepository $accountRepository, UserInterface $user): Response
    {
        $id = $user->id;
        $user = $this->getUser();
        $roles = $user->getRoles();
        if ($roles[0] == 'ROLE_ADMIN') {
            return $this->render('account/index.html.twig', [
                'accounts' => $accountRepository->findAll(),
                'role'=>$roles[0]
            ]);
        } else {
            return $this->render('account/index.html.twig', [
                'accounts' => $accountRepository->findBy(["UserId" => $id]),
                'role'=>$roles[0]
            ]);
        }
    }

    /**
     * @Route("/new", name="account_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $account = new Account();
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('account_index');
        }

        return $this->render('account/new.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="account_show", methods={"GET"})
     */
    public function show(Account $account): Response
    {
        return $this->render('account/show.html.twig', [
            'account' => $account,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="account_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Account $account): Response
    {
        $form = $this->createForm(AccountType::class, $account);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_index');
        }

        return $this->render('account/edit.html.twig', [
            'account' => $account,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="account_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Account $account): Response
    {
        if ($this->isCsrfTokenValid('delete' . $account->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($account);
            $entityManager->flush();
        }

        return $this->redirectToRoute('account_index');
    }
}
