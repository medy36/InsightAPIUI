<?php

namespace Projects\InsightAPiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use SensioLabs\Insight\Sdk\Api;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Projects\InsightAPiBundle\Entity\Analyses;
use Projects\InsightAPiBundle\Entity\AnalysesRepository;
use Projects\InsightAPiBundle\Entity\Analysis;
use Projects\InsightAPiBundle\Entity\AnalysisRepository;
use Projects\InsightAPiBundle\Entity\Link;
use Projects\InsightAPiBundle\Entity\Violations;
use Projects\InsightAPiBundle\Entity\Violation;

use Project\InsightAPiBundle\Filter\violationFilterType;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;




class DashboardController extends Controller
{

    // load Analysis, if not exist save it, if not exsit in Insight error number
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($this->get('request')->request->has('submit') ) {
            
            $request = $this->get('request');
           
            // get Analysis number value
            $analysisSearched = $request->request->get('analysisId');
            // liste analyses from Repo
            $analysisLocal = $em->getRepository('ProjectsInsightAPiBundle:Analysis')->isAnalysis($analysisSearched);
            

            // Analyse not stored yet and not checked in Insight
            if(!$analysisLocal)
            {

                // analyse not in DB !!! so get it from Insight and save it-------------------------
                $api= $this->getApi();



               $ProjectUuid = "ff6f44ef-e34a-4f9c-aca0-99498f5335dd";

               $AnalyApi= $api->getAnalysis($ProjectUuid,$analysisSearched)->getViolations();
                              


                // save Ananlyses into DB by following these steps:
          
                // 1.1 - get the Analysis by the ID given  
                // check if the Analysis exist in Insight          
                try {
                     $AnalyApi= $api->getAnalysis($ProjectUuid,$analysisSearched);
                } catch (\Symfony\Component\HttpKernel\Exception\HttpException $exc) {
                    throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('no analyse found IN iNSIGHT with the given number'); 
                }         
                      
                // 1.2 - all violations of the GIVEN analysis
                
                $analyViols= $api->getAnalysis($ProjectUuid,$analysisSearched)->getViolations();
                /*var_dump($AnalyViols);
                die;*/
               
                 // 2 - Analyses instance
                
                $analyses = new Analyses();
            
                 // 2.1- get the links of Ananlyses (note: Analyses contain all the analyses done till the moment), charge them in Link and then affect them to Analyses
                        
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
                      
                         
                // get links of the analyse 
                $analLinkSelf = $AnalyApi->getLinks();
            
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
               
               
                $analysis->setNumber($AnalyApi->getNumber());
                $analysis->setGrade($AnalyApi->getGrade());
                
                $analysis->setNextGrade($AnalyApi->getNextGrade());
                $analysis->setRemediationCost($AnalyApi->getRemediationCost());
                $analysis->setRemediationCostForNextGrade($AnalyApi->getRemediationCostForNextGrade());
                $analysis->setNbViolations($AnalyApi->getNbViolations());
               
                $analysis->setBeginAt($AnalyApi->getBeginAt());
                $analysis->setEndAt($AnalyApi->getEndAt());
    //            $analysis->setDuration($lastAnaly->getDuration());
    //            $analysis->setFailureMessage($lastAnaly->getFailureMessage());
    //            $analysis->setFailureCode($lastAnaly->getFailureCode());
                $analysis->setFailed($AnalyApi->isFailed());
                $analysis->setStatus($AnalyApi->getStatus());
                $analysis->setIsAltered($AnalyApi->isAltered());
                
                
                $analyses->addAnalysis($analysis);
                
                // set Violations of the Analysis -----------------------------
                
                $violations = new Violations();
                $violations->setAnalysis($analysis);
    //            var_dump($AnalyViols);
    //            die;
                
                 foreach ($analyViols as $viols)
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

                 //   $viol->setMD5(Md5(title,severity,source,message))
                    $em->persist($viol);
                   
                }
              
                  
                
                $em->persist($analyses);
                $em->persist($analysis);
                $em->persist($violations);
                   
                $em->flush();  
                  
                 
                return $this->render("ProjectsInsightAPiBundle:Front:step1.html.twig",array(
            
                    'analyNbr' => $analysisSearched,
                    'AnalyViols' => $analyViols
                ));
                // End saving new analyse proposed and checked in Insight!!!
                // throw $this->createNotFoundException('Unable to find Analysis entity.');
            }

             // if analyse exist in DB, load it's Violations
               $violations = $em->getRepository('ProjectsInsightAPiBundle:Violation')->byAnalysis($analysisSearched);

                if(!$violations)
            {
                 throw new AccessDeniedHttpException('no violations found for the Entity number'); 
             }

            

            return $this->render("ProjectsInsightAPiBundle:Front:step1.html.twig",array(
            
                    'analyNbr' => $analysisSearched,
                    'AnalyViols' => $violations->getResult()
                ));

            echo "analyse was found";
 
          

        }

         return $this->render('ProjectsInsightAPiBundle:Front:step1.html.twig');
        
        
    }
    // get analyses from DB -- not important till the API is fixed
    public function analysesAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        // liste analyses from Repo
         $analyses = $em->getRepository('ProjectsInsightAPiBundle:Analyses')->findAll();
 
         
        
        
     return $this->render('ProjectsInsightAPiBundle:Dashboard:analyses.html.twig', array(
            'analyses' => $analyses
        ));
    }
    
     // get analysis of Analyses selected from DB
    public function analysisAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        // liste analyses from Repo
         $analysis = $em->getRepository('ProjectsInsightAPiBundle:Analysis')->childAnalysis($slug);
 
         
        
        
     return $this->render('ProjectsInsightAPiBundle:Dashboard:analysis.html.twig', array(
            'analysis' => $analysis
        ));
    }

    private function getApi()
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
            return $api;
    }
    
}
