<?php
namespace Faculte\AdminBundle\Controller;


use Faculte\AdminBundle\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faculte\AdminBundle\Entity\Location;
use Faculte\AdminBundle\Form\FiliereType;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends controller
{
    public function ajouterLocationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Location = new Location();
        $form = $this->createForm( LocationType::class, $Location);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                    $Location = $form->getData();
                    $em->persist($Location);
                    $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_locations'));

            }
        }

        return $this->render('FaculteAdminBundle:Location:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function modifierLocationAction($idL,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Location=$em->getRepository('FaculteAdminBundle:Location')->findOneById($idL);
        $form = $this->createForm(LocationType::class, $Location);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $Location = $form->getData();
                $em->persist($Location);
                $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_locations'));

            }
        }

        return $this->render('FaculteAdminBundle:Location:modifier.html.twig', array(
            'form' => $form->createView(),'Location'=>$Location));

    }


    public function supprimerLocationAction($idL,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Location=$em->getRepository('FaculteAdminBundle:Location')->findOneById($idL);
        $em->remove($Location);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_locations'));


    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Location=$em->getRepository('FaculteAdminBundle:Location')->findAll();
        return $this->render('FaculteAdminBundle:Location:index.html.twig',array('Locations'=>$Location));

    }

    public function consulterLocationAction($idL,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Location=$em->getRepository('FaculteAdminBundle:Location')->findOneById($idL);
        return $this->render('FaculteAdminBundle:Location:consulte.html.twig',array('Location'=>$Location));

    }












}