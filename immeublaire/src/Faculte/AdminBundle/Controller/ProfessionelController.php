<?php
namespace Faculte\AdminBundle\Controller;



use Faculte\AdminBundle\Entity\Professionel;
use Faculte\AdminBundle\Entity\Particulier;
use Faculte\AdminBundle\Entity\Association;
use Faculte\AdminBundle\Entity\User;
use Faculte\AdminBundle\Form\AssociationType;
use Faculte\AdminBundle\Form\ParticulierType;
use Faculte\AdminBundle\Form\ProfessionelEditType;
use Faculte\AdminBundle\Form\ProfessionelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faculte\AdminBundle\Form\UserType;
use Faculte\AdminBundle\Form\ProfessionelFileEditType;
use Faculte\AdminBundle\Form\UserEditType;
use Symfony\Component\HttpFoundation\Request;

class ProfessionelController extends controller
{
    public function ajouterProfessionelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Professionel = new Professionel();
        $Professionel->setDateCreation(new \DateTime('now'));
        $form = $this->createForm( ProfessionelType::class, $Professionel);
        $form->handleRequest($request);
        $user = new User();
        $form2 = $this->createForm( UserType::class, $user);
        $form2->handleRequest($request);
        $Particulier = new Particulier();
        $Particulier->setDateCreation(new \DateTime('now'));
        $form3 = $this->createForm( ParticulierType::class, $Particulier);
        $form3->handleRequest($request);
        $user = new User();
        $form4 = $this->createForm( UserType::class, $user);
        $form4->handleRequest($request);
        $Association = new Association();
        $Association->setDateCreation(new \DateTime('now'));
        $form5 = $this->createForm( AssociationType::class, $Association);
        $form5->handleRequest($request);
        $user = new User();
        $form6 = $this->createForm( UserType::class, $user);
        $form6->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            if ($request->getMethod() == 'POST') {
                $Profs=$em->getRepository('FaculteAdminBundle:Professionel')->findAll();
                /**@var Professionel $Professionel**/
                $Professionel = $form->getData();
                //recuperer les données du formulaire
                /**@var User $user*/
                $user = $form2->getData();
                //ajouter role enseignant
                $role = array('ROLE_ENSEIGNANT');
                $user->setRoles($role);
                $user->setEnabled(true);
                $passwordProfessionel = $user->getPlainPassword();
                //persist(mis en memoire l'objet $user)
                $em->persist($user);
                //affecter l'objet user à l'enseignant
                $Professionel->setUser($user);
                $find=false;
                foreach ($Profs as $prof){
                    /**@var Profs $prof**/

                    if($prof->getUser()->getUsername() == $Professionel->getUser()->getUsername()||
                        $prof->getUser()->getEmail() == $Professionel->getUser()->getEmail()||
                        $prof->getDenomination() == $Professionel->getDenomination()) {
                        $find=true;
                        break;
                    }
                }
                if($find==true){
                    $errorPros = "Cette enregistrement déjà existe";
                    return $this->render('FaculteAdminBundle:Professionel:MsgErreur.html.twig', array(
                        'form' => $form->createView(),'errorPros'=>$errorPros,'form2' => $form2->createView()
                    ));
                }else{
                    //persist(mis en memoire l'objet $Professionel)
                    $Professionel ->uploadPathFile();
                    $em->persist($Professionel);
                    $em->flush();
                    $Professionel ->movePathFile();
                    return $this->redirect($this->generateUrl('faculte_admin_professionels'));
                }

           }
        }
        elseif ($form3->isSubmitted() && $form3->isValid() && $form4->isSubmitted() && $form4->isValid()) {
            if ($request->getMethod() == 'POST') {
                $Parts=$em->getRepository('FaculteAdminBundle:Particulier')->findAll();
                /**@var Particulier $Particulier**/
                $Particulier = $form3->getData();
                //recuperer les données du formulaire
                /**@var User $user*/
                $user = $form4->getData();
                //ajouter role particulier
                $role = array('ROLE_ENSEIGNANT');
                $user->setRoles($role);
                $user->setEnabled(true);
                $passwordParticulier = $user->getPlainPassword();
                //persist(mis en memoire l'objet $user)
                $em->persist($user);
                //affecter l'objet user à particulier
                $Particulier->setUser($user);
                //persist(mis en memoire l'objet $Particulier)
                $find=false;
                foreach ($Parts as $particuls){
                    /**@var Parts $particuls**/
                    if($particuls->getUser()->getUsername() == $Particulier->getUser()->getUsername()||
                        $particuls->getUser()->getEmail() == $Particulier->getUser()->getEmail() ||
                        $particuls->getNom() == $Particulier->getNom() &&  $particuls->getPrenom() == $Particulier->getPrenom()) {
                        $find=true;
                        break;
                    }
                }

                if($find==true){
                    $errorParticulier = "Cette enregistrement déjà existe";
                    return $this->render('FaculteAdminBundle:Professionel:MsgErreur.html.twig', array(
                        'form3' => $form3->createView(),'form4' => $form4->createView(),'Particulier'=>$Particulier,'errorParticulier'=>$errorParticulier,
                    ));
                }else {
                    $em->persist($Particulier);
                    $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_particuliers'));
                }
            }
        }elseif ($form5->isSubmitted() && $form5->isValid() && $form6->isSubmitted() && $form6->isValid()) {
            if ($request->getMethod() == 'POST') {
                $Assos=$em->getRepository('FaculteAdminBundle:Association')->findAll();
                /**@var Particulier $Particulier**/
                $Association = $form5->getData();
                //recuperer les données du formulaire
                /**@var User $user*/
                $user = $form6->getData();
                //ajouter role particulier
                $role = array('ROLE_ENSEIGNANT');
                $user->setRoles($role);
                $user->setEnabled(true);
                //persist(mis en memoire l'objet $user)
                $em->persist($user);
                //affecter l'objet user à particulier
                $Association->setUser($user);
                //persist(mis en memoire l'objet $Particulier)
                $find=false;
                foreach ($Assos as $assosiation){
                    /**@var Assos $assosiation**/
                    if($assosiation->getUser()->getUsername() == $Association->getUser()->getUsername()||
                        $assosiation->getUser()->getEmail() == $Association->getUser()->getEmail() ||
                        $assosiation->getNom() == $Association->getNom() &&  $assosiation->getPrenom() == $Association->getPrenom()) {
                        $find=true;
                        break;
                    }
                }

                if($find==true){
                    $errorAssociation = "Cette enregistrement déjà existe";
                    return $this->render('FaculteAdminBundle:Professionel:MsgErreur.html.twig', array(
                        'form5' => $form5->createView(),'form6' => $form6->createView(),'Association'=>$Association,'errorAssociation'=>$errorAssociation,
                    ));
                }else {
                    $em->persist($Association);
                    $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_associations'));
                }
            }
        }

        return $this->render('FaculteAdminBundle:Professionel:ajouter.html.twig', array(
            'form' => $form->createView(),'form2' => $form2->createView(),'form3' => $form3->createView(),'form4' => $form4->createView()
        ,'form5' => $form5->createView(),'form6' => $form6->createView()
        ));
    }

    public function modifierProfesionnelAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Professionel=$em->getRepository('FaculteAdminBundle:Professionel')->findOneById($id);
        $user=$Professionel->getUser();
        $form = $this->createForm(ProfessionelEditType::class, $Professionel);
        $form2 = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $form2->isSubmitted() && $form2->isValid()) {
            if ($request->isMethod('POST')) {
                $Profs=$em->getRepository('FaculteAdminBundle:Professionel')->findWithoutId($id);
                /**@var Profs $Professionel**/
                $Professionel = $form->getData();
                $user = $form2->getData();
                $em->persist($user);
                $Professionel->setUser($user);
                $find=false;
                foreach ($Profs as $professionels){
                    /**@var Profs $professionels**/
                    if($professionels->getUser()->getUsername() == $Professionel->getUser()->getUsername()||
                        $professionels->getUser()->getEmail() == $Professionel->getUser()->getEmail()||
                        $professionels->getDenomination() == $Professionel->getDenomination()) {
                        $find=true;
                        break;
                    }
                }
                if($find==true){
                    $errorProfessionel = "Cette enregistrement déjà existe";
                    return $this->render('FaculteAdminBundle:Professionel:MsgErreurModif.html.twig', array(
                        'form' => $form->createView(),'form2' => $form2->createView(),'Professionel'=>$Professionel,'errorProfessionel'=>$errorProfessionel,
                    ));
                } else {
                    $em->persist($Professionel);
                    $em->flush();
                    return $this->redirect($this->generateUrl('faculte_admin_professionels'));
                }
            }
        }

        return $this->render('FaculteAdminBundle:Professionel:modifier.html.twig', array(
            'form' => $form->createView(),'form2' => $form2->createView(),'Professionel'=>$Professionel));


    }


    public function modifierProfessionelFileAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Professionel=$em->getRepository('FaculteAdminBundle:Professionel')->findOneById($id);
        $form = $this->createForm(ProfessionelFileEditType::class, $Professionel);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $Professionel->uploadPathFile();
            $em->persist($Professionel);
            $em->flush();
            return $this->redirect($this->generateUrl('faculte_admin_professionels'));
        }
        return $this->render('FaculteAdminBundle:Professionel:modifierEdit.html.twig', array('Professionel' =>  $Professionel,
            'form' => $form->createView()
        ));
    }


    public function supprimerProfessionelAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Professionel=$em->getRepository('FaculteAdminBundle:Professionel')->findOneById($id);
            $em->remove($Professionel);
            $em->remove($Professionel->getUser());
            $em->flush();
        return $this->redirect($this->generateUrl('faculte_admin_professionels'));

    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Professionels=$em->getRepository('FaculteAdminBundle:Professionel')->findAll();
        return $this->render('FaculteAdminBundle:Professionel:index.html.twig',array('Professionels'=>$Professionels));
    }

    public function consulterProfessionelAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Professionel=$em->getRepository('FaculteAdminBundle:Professionel')->findOneById($id);
        return $this->render('FaculteAdminBundle:Professionel:consulte.html.twig',array('professionel'=>$Professionel));

    }


    public function renderVillesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idRegion = $request->request->get('idregion');
        $region = $em->getRepository('FaculteAdminBundle:Region')->find($idRegion);
        $villes = $em->getRepository('FaculteAdminBundle:Ville')->findBy(array('region'=>$region));

        $idProfessionel = $request->request->get('idProfessionel');
        $Professionel = null;
        if(!empty($idProfessionel)){
            $Professionel = $em->getRepository('FaculteAdminBundle:Professionel')->find($idProfessionel);
        }

        return $this->render('FaculteAdminBundle:Professionel:renderVilles.html.twig',array('villes'=>$villes,'Professionel'=>$Professionel));
    }

}