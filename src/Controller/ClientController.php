<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use App\Form\DetteFilterType;
use App\Form\FilterClientType;
use App\Repository\ClientRepository;
use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;  
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientController extends AbstractController
{
    #[Route('/client/Liste', name: 'client.index')]
    public function index(ClientRepository $clientRepository,Request $request): Response
    {
        $form = $this->createForm(FilterClientType::class);
        $form->handleRequest($request);
    
     
        $clients = $clientRepository->findAll();
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
          
            $clients = $clientRepository->filterClients($data['numero'], $data['surname'], $data['createUser']);
        }
    
        return $this->render('client/index.html.twig', [
            'dataClient' => $clients,  
            'form' => $form->createView(),
        ]);

    }


    #[Route('/client/form', name: 'client.create')]
public function create(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
{
    $client = new Client();
    $form = $this->createForm(ClientType::class, $client);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        if ($form->get('createUser')->getData()) {
            $userData = $form->get('newUser')->getData();
            $roles = array_merge(is_array($userData->getRoles()) ? $userData->getRoles() : [$userData->getRoles()]);
            
            $user = new User();
            $user->setRoles($roles);
            $user->setLogin($userData->getLogin());
            
            $user->setPassword($userPasswordHasher->hashPassword($user,$userData->getPassword()));

            $entityManager->persist($user);
            $client->setUtilisateur($user);
        }

        $entityManager->persist($client);
        $entityManager->flush();

        return $this->redirectToRoute('client.index');
    }

    return $this->render('client/form.html.twig', [
        'client' => $client,
        'form' => $form->createView(),
    ]);
}

        


#[Route('/client/{id}/dettes', name: 'client.dettes')]
public function dettes(int $id,EntityManagerInterface $entityManager,Request $request,DetteRepository $detteRepository): Response
{
    $client = $entityManager->getRepository(Client::class)->find($id);

    $form=$this->createForm(DetteFilterType::class);
    $form->handleRequest($request);
    
        $dettes=$client->getDettes();

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();
        $dettes =$detteRepository->findByStatut($data['statut']);
    }


    if (!$client) {
        throw $this->createNotFoundException('Client non trouvé');
    }
    return $this->render('client/dettes.html.twig', [
        'client' => $client,
        'dettes' => $dettes,
        'form'=> $form->createView(),
    ]);
}

}
