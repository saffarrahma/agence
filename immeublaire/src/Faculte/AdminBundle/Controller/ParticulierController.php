<?php
namespace Faculte\AdminBundle\Controller;



use Faculte\AdminBundle\Entity\Particulier;
use Faculte\AdminBundle\Entity\User;
use Faculte\AdminBundle\Form\ParticulierType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faculte\AdminBundle\Form\UserType;
use Faculte\AdminBundle\Form\UserEditType;
use Symfony\Component\HttpFoundation\Request;

class ParticulierController extends controller
{
    public function modifierParticulierAction($idPR,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Particulier=$em->getRepository('FaculteAdminBundle:Particulier')->findOneById($idPR);
        $user=$Particulier->getUser();
        $form3 = $this->createForm(ParticulierType::class, $Particulier);
        $form4 = $this->createForm(UserEditType::class, $user);
        $form3->handleRequest($request);
        $form4->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid() && $form4->isSubmitted() && $form4->isValid()) {
            if ($request->isMethod('POST')) {
                $Parts=$em->getRepository('FaculteAdminBundle:Particulier')->findWithoutId($idPR);
                /**@var Parts $Particulier**/
                $Particulier = $form3->getData();
                $user = $form4->getData();
                $em->persist($user);
                $Particulier->setUser($user);
                $find=false;
                foreach ($Parts as $particuls){
                    /**@var Parts $particuls**/
                    if($particuls->getUser()->getUsername() == $Particulier->getUser()->getUsername()||
                        $particuls->getUser()->getEmail() == $Particulier->getUser()->getEmail()||
                        $particuls->getNom() == $Particulier->getNom() &&  $particuls->getPrenom() == $Particulier->getPrenom()) {
                        $find=true;
                        break;
                    }
                }
                if($find==true){
                    $errorParticulier = "Cette enregistrement déjà existe";
                    return $this->render('FaculteAdminBundle:Particulier:MsgErreurModif.html.twig', array(
                        'form3' => $form3->createView(),'form4' => $form4->createView(),'Particulier'=>$Particulier,'errorParticulier'=>$errorParticulier,
                    ));
                } else {
                    $em->persist($Particulier);
                    $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_particuliers'));
                }
            }
        }

        return $this->render('FaculteAdminBundle:Particulier:modifier.html.twig', array(
            'form3' => $form3->createView(),'form4' => $form4->createView(),'Particulier'=>$Particulier));


    }



    public function supprimerParticulierAction($idPR,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Particulier=$em->getRepository('FaculteAdminBundle:Particulier')->findOneById($idPR);
            $em->remove($Particulier);
            $em->remove($Particulier->getUser());
            $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_particuliers'));

    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Particuliers=$em->getRepository('FaculteAdminBundle:Particulier')->findAll();
        return $this->render('FaculteAdminBundle:Particulier:index.html.twig',array('Particuliers'=>$Particuliers));
    }

    public function consulterParticulierAction($idPR,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Particulier=$em->getRepository('FaculteAdminBundle:Particulier')->findOneById($idPR);
        return $this->render('FaculteAdminBundle:Particulier:consulte.html.twig',array('Particulier'=>$Particulier));

    }
}