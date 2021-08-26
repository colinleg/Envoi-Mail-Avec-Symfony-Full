<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MailerService;
use Symfony\Component\HttpFoundation\Request;


class MailSenderController extends AbstractController
{

    /**
     *
     * @param Request $req
     * @param MailerService $mailerService
     * @return Response
     */
    #[Route('/send', name: 'mail_sender')]
    public function contact(Request $req, MailerService $mailerService ): Response
    {

        $form = $this->createForm(ContactType::class, null);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();
            // dd($data);

            $mailerService->send(
                ['objetMsg' => $data['objetMsg']],
                'colin.legoedec@laposte.net',
                'colin.legoedec@laposte.net',
                'exMail/exampleMail.html.twig',
                [
                    'nom' => $data['nom'],
                    'message' => $data['message']
                ]
            );
        }

        return $this->render('mail_sender/index.html.twig', [
            'controller_name' => 'MailSenderController',
            'form' => $form->createView()
        ]);
    }
}
