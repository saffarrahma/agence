<?php

namespace Faculte\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VenteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Maison' => 'Maison',
                    'Terrain' => 'Terrain',
                    'Appartement' => 'Appartement')))
            ->add('source', ChoiceType::class, array(
                'choices' => array(
                    'Tayara' => 'Tayara',
                    'Site la casa' => 'Site la casa',
                    'Collaborateur interne' => 'Collaborateur interne',
                    'Autre ' => 'Autre')))
            ->add('professionel', EntityType::class, array(
                'class' => 'FaculteAdminBundle:Professionel',
                'placeholder' => 'Choisissez un Professionel',
                'required' => false,
                'empty_data' => null))
            ->add('particulier', EntityType::class, array(
                'class' => 'FaculteAdminBundle:Particulier',
                'placeholder' => 'Choisissez un Particulier',
                'required' => false,
                'empty_data' => null))
            ->add('association', EntityType::class, array(
                'class' => 'FaculteAdminBundle:Association',
                'placeholder' => 'Choisissez une Association',
                'required' => false,
                'empty_data' => null))
            ->add('numPiece')
            ->add('budget')
            ->add('carte')
            ->add('commentaire');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Faculte\AdminBundle\Entity\Vente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'faculte_adminbundle_vente';
    }


}
