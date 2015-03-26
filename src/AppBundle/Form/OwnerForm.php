<?php
namespace AppBundle\Form;
/**
 * I am the Owner form. I describe the requirements for a Owner form.
 *
 * @author John Allen
 * @version 1.0
 */

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
            ->add('firstName', 'text',  array('label' => 'First Name'))
            ->add('lastName', 'text',  array('label' => 'Last Name'))
            ->add('save', 'submit', array('label' => 'Save Owner'));
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