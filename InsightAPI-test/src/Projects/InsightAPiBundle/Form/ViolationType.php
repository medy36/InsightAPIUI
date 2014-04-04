<?php

namespace Projects\InsightAPiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ViolationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('message')
            ->add('resource')
            ->add('line')
            ->add('severity')
            ->add('category')
            ->add('createdAt')
            ->add('violations')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Projects\InsightAPiBundle\Entity\Violation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'projects_insightapibundle_violation';
    }
}
