<?php

namespace Projects\InsightAPiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use SensioLabs\Insight\Sdk\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Projects\InsightAPiBundle\Entity\Analyses;
use Projects\InsightAPiBundle\Entity\Analysis;
use Projects\InsightAPiBundle\Entity\AnalysisRepository;
use Projects\InsightAPiBundle\Entity\Link;
use Projects\InsightAPiBundle\Entity\Violations;
use Projects\InsightAPiBundle\Entity\Violation;

use Project\InsightAPiBundle\Filter\violationFilterType;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;




class APIController extends Controller
{
   
   
    
    
    public function dashboardAction()
    {
       
         // setting the credentials

            $userUuid = "2022c83d-abdf-4c5d-a612-ad16d55c4da2";
            $APIToken = "b50e050a18ecb16e7ad77eb6cebf29de8830583037b2dacad25f7007d97c2d7e";
            $ProjectUuid = "ff6f44ef-e34a-4f9c-aca0-99498f5335dd";
        
      
            // API instance
            $api = new Api(array(
                'api_token' => $APIToken,
                'user_uuid' => $userUuid,
            ));
           
            // get Links of Analyses et le nbr----------------------------
             $analysesLinks= $api->getAnalyses($ProjectUuid)->getLinks();
//             var_dump($analysesLinks);
//             die;
             $nbLinks = count($analysesLinks);
             
            // get all Analyses-------------------------------------
               $analyses= $api->getAnalyses($ProjectUuid)->getAnalyses();
               $nbAnalyses = count($analyses);
               
               
             // get last Analysis Number
        
             // $analysisNumber = $analyses[0]->getNumber();
              var_dump($analyses);
             
            //   get all data of the last analysis (too much heavy for now)
               $lastAnaly= $api->getAnalysis($ProjectUuid,$analysisNumber);
              //   get all violations of the last analysis
               $lastAnalyViols= $api->getAnalysis($ProjectUuid,$analysisNumber)->getViolations();  
               
//               var_dump($lastAnalyViols);
//               die;
        return $this->render("ProjectsInsightAPiBundle:Dashboard:dashboard.html.twig",array(
            
            'links' => $analysesLinks,
            'nbLinkAnalyses' => $nbLinks,
            'analyses' => $analyses,
            'nbAnalyses' => $nbAnalyses,
            'lastAnalyViols' => $lastAnalyViols
        ));
      
        
    }
    
    public function LoadViolsAction($slug)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        // setting the credentials

            $userUuid = "2022c83d-abdf-4c5d-a612-ad16d55c4da2";
            $APIToken = "b50e050a18ecb16e7ad77eb6cebf29de8830583037b2dacad25f7007d97c2d7e";
            $ProjectUuid = "ff6f44ef-e34a-4f9c-aca0-99498f5335dd";
        
      
       // API instance
            
            $api = new Api(array(
                'api_token' => $APIToken,
                'user_uuid' => $userUuid,
            ));
        
     
           
      
            
         // save Ananlyses into DB by following these steps:
         // 
            // 1.1 - get the Analysis by the ID given            
            try {
                 $lastAnaly= $api->getAnalysis($ProjectUuid,$slug);
            } catch (\SensioLabs\Insight\Sdk\Exception\ApiClientException $exc) {
                throw new AccessDeniedHttpException('no analyse found with the given number'); 
            }


           
           
           
            // 1.2 - all violations of the last analysis
            
            $lastAnalyViols= $api->getAnalysis($ProjectUuid,$slug)->getViolations();
            /*var_dump($lastAnalyViols);
            die;*/
           
             // 2 - Analyses instance
            
            $analyses = new Analyses();
            
             // 2.1- get the links of Ananlyses (note: Analyses contain all the analyses done till the moment), charge them in Link and then affect them Analyses
                    
            $analysesLinks = $api->getAnalyses($ProjectUuid)->getLinks();
    
            foreach ($analysesLinks as $link)
            {
                // instance Link for Analyses Links $analyLinks
                $link1 = new Link();
                $link1->setHref($link->getHref());
                $link1->setRel($link->getRel());
                $link1->setType($link->getType());
                $link1->setAnalyses($analyses); 
                $analyses->addLink($link1);
                $em->persist($link1);
                
            }
            
            // 
            $analysis = new Analysis();
            ////HERE

            $analysis->setAnalyses($analyses);
                  
                     
            // get links of the last analyse done till now
            $analLinkSelf = $lastAnaly->getLinks();
            
            foreach ($analLinkSelf as $link)
            {
                // instance Link for Analysis Links $analyLinkSelf
                $link2 = new Link();
                $link2->setHref($link->getHref());
                $link2->setType($link->getType());
                $link2->setRel($link->getRel());
                $link2->setHref($link->getType());
                $link2->setAnalysis($analysis);  
              
                $analysis->addLink($link2);
                $em->persist($link2);
               
                 
            }
           
           
            $analysis->setNumber($lastAnaly->getNumber());
            $analysis->setGrade($lastAnaly->getGrade());
            
            $analysis->setNextGrade($lastAnaly->getNextGrade());
            $analysis->setRemediationCost($lastAnaly->getRemediationCost());
            $analysis->setRemediationCostForNextGrade($lastAnaly->getRemediationCostForNextGrade());
            $analysis->setNbViolations($lastAnaly->getNbViolations());
           
            $analysis->setBeginAt($lastAnaly->getBeginAt());
            $analysis->setEndAt($lastAnaly->getEndAt());
//            $analysis->setDuration($lastAnaly->getDuration());
//            $analysis->setFailureMessage($lastAnaly->getFailureMessage());
//            $analysis->setFailureCode($lastAnaly->getFailureCode());
            $analysis->setFailed($lastAnaly->isFailed());
            $analysis->setStatus($lastAnaly->getStatus());
            $analysis->setIsAltered($lastAnaly->isAltered());
            
            
            $analyses->addAnalysis($analysis);
            
            // set Violations of the last Analysis -----------------------------
            
            $violations = new Violations();
            $violations->setAnalysis($analysis);
//            var_dump($lastAnalyViols);
//            die;
            
             foreach ($lastAnalyViols as $viols)
            {
                // instance Link for Analysis Links $analyLinkSelf
                $viol = new Violation();
                $viol->setTitle($viols->getTitle());
                $viol->setLine($viols->getLine());
                $viol->setMessage($viols->getMessage());
                $viol->setResource($viols->getResource());
                $viol->setSeverity($viols->getSeverity());
                $viol->setCategory($viols->getcategory());
                $viol->setViolations($violations);
                $em->persist($viol);
               
            }
          
              
            
            $em->persist($analyses);
            $em->persist($analysis);
            $em->persist($violations);
               
            $em->flush();  
           
              
        return $this->render("ProjectsInsightAPiBundle:Dashboard:violationDetail.html.twig",array(
            
            'analyNbr' => $slug,
            'lastAnalyViols' => $lastAnalyViols
        ));
    }
    
    
    public function testFilterAction()
    {
        // From the FilterType, 
         
        $em = $this->getDoctrine()->getManager();
         
        $request = Request::createFromGlobals();
        // get instance of Filter Form Type, and form action route
        $form = $this->get('form.factory')->create(new \Projects\InsightAPiBundle\Filter\ViolationsFilterType(),array(
            
          'action' => $this->generateUrl('projects_insight_a_pi_Filterpage'),
        ));
        


        if ($this->get('request')->request->has('submit-filter')) {
            
            // bind values from the request
            $form->handleRequest($this->get('request'));
            
            // get Analysis number value
            $analysisSearched = $request->request->get('insight_violations_filter');
            
            // make sure the $analysisSearched is array
            if(is_array($analysisSearched)){
                
            // get analyse number  if was mentioned From REQUEST
            $analynbr= $analysisSearched['analysis'];
            
//            var_dump($analynbr);
//            die;
            }

            $searchAnalysis = $em->getRepository('ProjectsInsightAPiBundle:Analysis')->isAnalysis($analynbr);
 
            if($searchAnalysis === 0)
            {
                $flash = 'no analyse was saved with given Number';
                echo $flash;
            }  else {
                
               // initialize a query builder
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                                    ->getRepository('ProjectsInsightAPiBundle:Violation')
                                    ->createQueryBuilder('v')
                                    ->leftJoin('v.violations', 'vs')
                                    ->leftJoin('vs.analysis', 'a')
                                    
                                    
                    ;
          
              

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);
            // now look at the DQL =)$result = $query->getResult();getQuery()->getArrayResult()
//                  var_dump($filterBuilder->getQuery()->getArrayResult());  
            $result = $filterBuilder->getQuery()->getArrayResult();
           // var_dump($result);die;
            
             return $this->render('ProjectsInsightAPiBundle:Dashboard:dynamicTable.html.twig', array(
                 
                  'form' => $form->createView(),
                  'result' => $result
                ));
            }
              
            
        
            
            
        
        }

        return $this->render('ProjectsInsightAPiBundle:Dashboard:dynamicTable.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    
    
    
}

