<?php
namespace AppBundle\Form\Cat;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OwnerForm extends AbstractType {

    /**
     * I describe the Owner form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('id', 'hidden')
            ->add('firstName')
            ->add('lastName');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Owner',
        ));
    }

    /**
     * I return the name of the form.
     *
     * @return string
     */
    public function getName(){
        return 'owner';
    }
}