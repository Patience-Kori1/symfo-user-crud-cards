<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomePageController extends AbstractController
{
     #[Route('/', name: 'app_home_page')]
    public function index(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('home_page/homePage.html.twig', [
            'users' => $users,
        ]);
    }

   #[Route('/create', name:'app_create_form')]

   public function create(Request $request, EntityManagerInterface $em) : Response
   {
        $user = new User;
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
            if( $form->isSubmitted() && $form->isValid()) {
                $em -> persist($user);
                $em -> flush();
                return $this->redirectToRoute('app_home_page');
               
            }

        return $this->render('form/create.html.twig', [
            'form'=>$form
        ]);
   }

}
