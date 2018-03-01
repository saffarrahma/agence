<?php

namespace Faculte\AdminBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ProfessionelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('denomination')
                ->add('presenter')
            ->add('ville', EntityType::class, array(
                'class' => 'FaculteAdminBundle:Ville',
                'placeholder' => 'Choisissez une ville',
                'empty_data' => null))
                ->add('organisation')
                ->add('matricule')
                ->add('adresse')
                ->add('codepostal')
            ->add('region', EntityType::class, array(
                'class' => 'FaculteAdminBundle:Region',
                'placeholder' => 'Choisissez une région',
                'empty_data' => null,
                'mapped' => false,
                'required' => true,
                'multiple' => false))
            ->add('telephone')
                ->add('portable')
                ->add('fax')
                ->add('pathFile',FileType::Class, array('data_class' => null, 'required'=>false)) ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Faculte\AdminBundle\Entity\Professionel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'faculte_adminbundle_professionel';
    }


}
