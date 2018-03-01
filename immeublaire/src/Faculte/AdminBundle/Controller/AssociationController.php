<?php
namespace Faculte\AdminBundle\Controller;



use Faculte\AdminBundle\Entity\Particulier;
use Faculte\AdminBundle\Entity\User;
use Faculte\AdminBundle\Form\AssociationType;
use Faculte\AdminBundle\Form\ParticulierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faculte\AdminBundle\Form\UserType;
use Faculte\AdminBundle\Form\UserEditType;
use Symfony\Component\HttpFoundation\Request;

class AssociationController extends controller
{

    public function modifierAssociationAction($idA,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Association=$em->getRepository('FaculteAdminBundle:Association')->findOneById($idA);
        $user= $Association->getUser();
        $form5 = $this->createForm(AssociationType::class, $Association);
        $form6 = $this->createForm(UserEditType::class, $user);
        $form5->handleRequest($request);
        $form6->handleRequest($request);
        if ($form5->isSubmitted() && $form5->isValid() && $form6->isSubmitted() && $form6->isValid()) {
            if ($request->isMethod('POST')) {
                $Assos=$em->getRepository('FaculteAdminBundle:Association')->findWithoutId($idA);
                /**@var Assos $Association**/
                $Particulier = $form5->getData();
                $user = $form6->getData();
                $em->persist($user);
                $Association->setUser($user);
                $find=false;
                foreach ($Assos as $assosiation) {
                    /**@var Assos $assosiation * */
                    if ($assosiation->getUser()->getUsername() == $Association->getUser()->getUsername() ||
                        $assosiation->getUser()->getEmail() == $Association->getUser()->getEmail() ||
                        $assosiation->getNom() == $Association->getNom() && $assosiation->getPrenom() == $Association->getPrenom()) {
                        $find = true;
                        break;
                    }
                }
                    if ($find == true) {
                        $errorAssociation = "Cette enregistrement déjà existe";
                        return $this->render('FaculteAdminBundle:Association:MsgErreurModif.html.twig', array(
                            'form5' => $form5->createView(), 'form6' => $form6->createView(), 'Association' => $Association, 'errorAssociation' => $errorAssociation,
                        ));
                    } else {
                        $em->persist($Association);
                        $em->flush();
                        return $this->redirect($this->generateUrl('faculte_admin_associations'));
                    }
                    
            }
        }


        return $this->render('FaculteAdminBundle:Association:modifier.html.twig', array(
            'form5' => $form5->createView(),'form6' => $form6->createView(),'Association'=>$Association));


    }



    public function supprimerAssociationAction($idA,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Associations=$em->getRepository('FaculteAdminBundle:Association')->findOneById($idA);
            $em->remove($Associations);
            $em->remove($Associations->getUser());
            $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_associations'));

    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Associations=$em->getRepository('FaculteAdminBundle:Association')->findAll();
        return $this->render('FaculteAdminBundle:Association:index.html.twig',array('Associations'=>$Associations));
    }

    public function consulterAssociationAction($idA,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Associations=$em->getRepository('FaculteAdminBundle:Association')->findOneById($idA);
        return $this->render('FaculteAdminBundle:Association:consulte.html.twig',array('Association'=>$Associations));

    }
}