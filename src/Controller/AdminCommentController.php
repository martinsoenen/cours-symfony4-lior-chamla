<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Form\AdminCommentType;
use App\Repository\CommentRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comments_index")
     */
    public function index(CommentRepository $repo, $page, PaginationService $pagination)
    {
        $pagination->setEntityClass(Comment::class)
                    ->setCurrentPage($page);

        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * Permet de modifier un commentaire
     *
     * @Route("/admin/comment/{id}/edit", name="admin_comments_edit")
     *
     * @param Comment $comment
     * @return Response
     */
    public function edit(Comment $comment, Request $request, EntityManagerInterface $manager) {
        $form = $this->createForm(AdminCommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', "Le commentaire numéro <strong>{$comment->getId()}</strong> a bien été modifié !");
        }

        return $this->render('admin/comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un commentaire
     *
     * @Route("/admin/comments/{id}/delete", name="admin_comments_delete")
     *
     * @param Comment $comment
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Comment $comment, EntityManagerInterface $manager) {
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash('success', "Le commentaire de <strong>{$comment->getAuthor()->getFullName()}</strong> a bien été supprimé !");

        return $this->redirectToRoute('admin_comments_index');
    }

}
