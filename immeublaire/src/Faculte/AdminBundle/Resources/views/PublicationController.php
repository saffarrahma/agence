<?php

namespace Faculte\FrontBundle\Controller;

use Faculte\AdminBundle\Entity\Commentaire;
use Faculte\AdminBundle\Form\CommentaireType;
use Faculte\AdminBundle\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faculte\AdminBundle\Entity\Publier;
use Faculte\AdminBundle\Entity\Filiere;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;




class PublicationController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $publiers=$em->getRepository('FaculteAdminBundle:Publier')->findAll();
        return $this->render('FaculteFrontBundle:Default:index.html.twig', array('publiers'=>$publiers));
    }

    public function publierAction($idPublier)
    {
        $em = $this->getDoctrine()->getManager();
        $publiers=$em->getRepository('FaculteAdminBundle:Publier')->findOneById($idPublier);
        $comms=$em->getRepository('FaculteAdminBundle:Commentaire')->findAll();

        return $this->render('FaculteFrontBundle:Inscription:Publication.html.twig', array('publiers'=>$publiers , 'comms'=>$comms));

    }

    public function AjouterCommentaireAction(Request $request,$idPublier)
    {

        $em = $this->getDoctrine()->getManager();
        $commentaire = new Commentaire();
        $commentaire->setPublication($idPublier);
        $commentaire->setDateAjout(new \DateTime('now'));
        $form = $this->createForm( CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            if ($request->getMethod() == 'POST') {
                $commentaire = $form->getData();
                $em->persist($commentaire);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_front_homepage'));
            }
        }

        return $this->render('FaculteFrontBundle:Inscription:pub.html.twig', array(
            'form' => $form->createView()));
    }


}
