<?php

namespace Projects\InsightAPiBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Projects\InsightAPiBundle\Entity\Violation;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class ViolationsFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('analysis', 'filter_number', array(
            'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
                if ($values['value']) {
                    $qb = $filterQuery->getQueryBuilder();
                    $qb
                        ->andWhere('a.number = :number')
                        ->setParameter('number', $values['value'])
                    ;
                }
            },
        ));
        $builder->add('severity','filter_choice', array(
            
                        'choices'   => array(
                            
                                'info'  => 'Info',
                                'minor' => 'Minor',
                                'major' => 'Major',
                              ),
                        'multiple'  => true,
                    ));
        $builder->add('resource', 'filter_entity',array(
            
            'class' => 'ProjectsInsightAPiBundle:Violation',
            'property' => 'resource',
            'query_builder' => function(EntityRepository $v) {
                
              return $v->createQueryBuilder('v')                  
                       ->orderBy('v.resource', 'ASC')
                       ->groupBy('v.resource');
               } ,
            
            'apply_filter' => function (QueryInterface $filterQuery, $field, $values) {
      
                if ($values['value']) {
                    
                    $qb = $filterQuery->getQueryBuilder();
                    $qb
                        ->andWhere('v.resource = :src')
                        ->setParameter('src', $values['value']->getResource())
                    ;
                }
            },
            
            ));
    }

    public function getName()
    {
        return 'insight_violations_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}

