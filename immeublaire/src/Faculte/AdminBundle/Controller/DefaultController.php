<?php

namespace Faculte\AdminBundle\Controller;
use Faculte\AdminBundle\Entity\Region;
use Faculte\AdminBundle\Form\RegionType;
use Faculte\AdminBundle\Entity\Ville;
use Faculte\AdminBundle\Form\VilleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Particulier = $em->getRepository('FaculteAdminBundle:Particulier')->findAll();
        $Professionel = $em->getRepository('FaculteAdminBundle:Professionel')->findAll();
        $Association = $em->getRepository('FaculteAdminBundle:Association')->findAll();


        return $this->render('FaculteAdminBundle:Default:index.html.twig',array('Particulier'=>$Particulier, 'Association'=>$Association
        , 'Professionel'=>$Professionel));

    }
    public function ajouterRegionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Region = new Region();
        $form = $this->createForm( RegionType::class, $Region);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $Region = $form->getData();
                 $em->persist($Region);
                 $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_regions'));

            }
        }

        return $this->render('FaculteAdminBundle:Region:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function listeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Regions=$em->getRepository('FaculteAdminBundle:Region')->findAll();
        return $this->render('FaculteAdminBundle:Region:index.html.twig',array('Regions'=>$Regions));

    }

    public function ajouterVilleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Ville = new Ville();
        $form = $this->createForm( VilleType::class, $Ville);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $Ville = $form->getData();
                $em->persist($Ville);
                $em->flush();
                return $this->redirect($this->generateUrl('faculte_admin_villes'));

            }
        }

        return $this->render('FaculteAdminBundle:Ville:ajouter.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function listeVilleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Villes=$em->getRepository('FaculteAdminBundle:Ville')->findAll();
        return $this->render('FaculteAdminBundle:Ville:index.html.twig',array('Villes'=>$Villes));

    }

}
