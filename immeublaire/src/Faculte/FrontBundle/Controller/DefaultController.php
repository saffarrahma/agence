<?php

namespace Faculte\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Faculte\AdminBundle\Entity\User;
use Faculte\AdminBundle\Entity\Inscription;
use Faculte\AdminBundle\Form\InscriptionType;
use Faculte\AdminBundle\Form\UserEmailType ;

class DefaultController extends Controller
{


    public function indexAction()
    {
        return $this->render('FaculteFrontBundle:Default:index.html.twig');
    }

    public function contactAction()
    {
        return $this->render('FaculteFrontBundle:Default:contact.html.twig');
    }

    public function InscriptionLigAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Inscription = new Inscription();
        $form = $this->createForm( InscriptionType::class, $Inscription);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            if ($request->getMethod() == 'POST') {
                $Inscription = $form->getData();
                $em->persist($Inscription);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_front_demandeEnregistre'));
            }
        }

        return $this->render('FaculteFrontBundle:Default:InscriptionLig.html.twig', array(
            'form' => $form->createView()
        ));
    }

}

