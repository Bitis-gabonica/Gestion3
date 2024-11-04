<?php

namespace App\Controller;

use App\Dto\DetteFilter;
use App\Entity\Client;
use App\Entity\Dette;
use App\Form\DetteFilterType;
use App\Form\DetteType;
use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class DetteController extends AbstractController
{
    #[Route('/dette/liste', name: 'dette.index',methods: ['GET', 'POST'])]
    public function index(DetteRepository $detteRepository, Request $request): Response
{
    dump($request->getMethod()); // Ajoutez ceci pour voir si la méthode est bien POST
    
    $detteFilter = new DetteFilter();
    $form = $this->createForm(DetteFilterType::class, $detteFilter);
    $form->handleRequest($request);

    $dettes = $detteRepository->findAll();
    if ($form->isSubmitted() && $form->isValid()) {
        $userData = $form->getData();
        dump('Formulaire soumis et valide');
        $dettes = $detteRepository->filterDette($userData->getStatut(), $userData->getClient(), $userData->getDate());
    }

    return $this->render('dette/index.html.twig', [
        'dettes' => $dettes,
        'form' => $form->createView(),
    ]);
}




    #[Route('/dette/{id}/form', name: 'dette.create')]
    public function create(EntityManagerInterface $entityManagerInterface, Request $request, $id): Response
    {

        $client=$entityManagerInterface->getRepository(Client::class)->find($id);
        $dette= new Dette();
        $form=$this->createForm(DetteType::class,$dette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dette->setClient($client);
            $client->addDette($dette);
            $entityManagerInterface->persist($dette);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('client.dettes', ['id' => $client->getId()]);
        }

        return $this->render('dette/form.html.twig', [
            'client' => $client,
            'form'=>$form->createView(),
        ]);
    }


    


}
