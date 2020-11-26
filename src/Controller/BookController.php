<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="book_")
 */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param BookRepository $bookRepository
     * @return Response
     */
    public function index(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        // Create new bookkkkzzzzz
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->getErrors();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($book);
            $em->flush();

            return $this->redirect($this->generateUrl('book_index'));

        }

        return $this->render('book/create.html.twig', [
            'form' => $form->createView()
        ]);



    }


    /**
     * @Route("/update/{id}", name="update")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $book = new Book();

        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);

        $form = $this->createForm(BookType::class, $book);
        $form->getErrors();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirect($this->generateUrl('book_index'));

        }

        return $this->render('book/update.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
