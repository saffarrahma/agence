<?php
namespace Faculte\AdminBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faculte\AdminBundle\Entity\Vente;
use Faculte\AdminBundle\Form\VenteType;
use Symfony\Component\HttpFoundation\Request;

class VenteController extends controller
{
    public function ajouterVenteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Vente = new Vente();
        $form = $this->createForm( VenteType::class, $Vente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                    $Vente = $form->getData();
                    $em->persist($Vente);
                    $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_ventes'));

            }
        }

        return $this->render('FaculteAdminBundle:Vente:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function modifierVenteAction($idV,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Vente=$em->getRepository('FaculteAdminBundle:Vente')->findOneById($idV);
        $form = $this->createForm(VenteType::class, $Vente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $Vente = $form->getData();
                $em->persist($Vente);
                $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_ventes'));

            }
        }

        return $this->render('FaculteAdminBundle:Vente:modifier.html.twig', array(
            'form' => $form->createView(),'Vente'=>$Vente));

    }


    public function supprimerVenteAction($idV,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Vente=$em->getRepository('FaculteAdminBundle:Vente')->findOneById($idV);
        $em->remove($Vente);
        $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_ventes'));


    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Vente=$em->getRepository('FaculteAdminBundle:Vente')->findAll();
        return $this->render('FaculteAdminBundle:Vente:index.html.twig',array('Ventes'=>$Vente));

    }

    public function consulterVenteAction($idV,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Vente=$em->getRepository('FaculteAdminBundle:Vente')->findOneById($idV);
        return $this->render('FaculteAdminBundle:Vente:consulte.html.twig',array('Vente'=>$Vente));

    }












}