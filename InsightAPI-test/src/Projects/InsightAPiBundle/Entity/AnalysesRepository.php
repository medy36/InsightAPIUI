<?php

namespace Projects\InsightAPiBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AnalysesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnalysesRepository extends EntityRepository
{
    
     public function allAnalyses()
    {
        
        $anas = $this->createQueryBuilder('a')
        ->select('a')
        ->getQuery();
        if(!$anas->getResult()){
             
            return 0;
            
        }else
        {
            return $anas;
        }

      
    }
}
