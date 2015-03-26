<?php
namespace AppBundle\Form;
/**
 * I am the Cat form. I describe the requirements for a form to submit a Cat.
 *
 * @author John Allen
 * @version 1.0
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CatForm extends AbstractType {

    /**
     * I describe the form to be built.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('id' ,'hidden')
            ->add('name')
            //->add('name', 'text', array( 'required' => false) )
            ->add('description')
            //->add('description', 'textarea', array( 'required' => false ))
            ->add('save', 'submit', array('label' => 'Save Cat'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions( OptionsResolverInterface $resolver ){
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cat',
        ));
    }

    /**
     * I return the 'name' of the form
     *
     * @return string
     */
    public function getName(){
        return 'cat';
    }
}