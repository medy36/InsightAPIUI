<?php

namespace Projects\InsightAPiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lsw\ApiCallerBundle\Call\HttpGetJson;
use SensioLabs\Insight\Sdk\Api;
use Symfony\Component\HttpFoundation\Response;
use Projects\InsightAPiBundle\Entity\Analyses;
use Projects\InsightAPiBundle\Entity\Analysis;
use Projects\InsightAPiBundle\Entity\Link;
use Projects\InsightAPiBundle\Entity\Violations;
use Projects\InsightAPiBundle\Entity\Violation;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ProjectsInsightAPiBundle:Dashboard:dynamicTable.html.twig');
    }
    
    public function ApiTestAction()
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
        
           // get the list of Analyses
            $analyses= $api->getAnalyses($ProjectUuid);
         
           // get the list of Analyses
          // $analyses= $api->getAnalysis($ProjectUuid,63)->getViolations();
           //----------------------
            // get the a Uniq analyse as "analysis"
         // print_r($api->getAnalysis($ProjectUuid,63));
            //---------------------
           
            
           // $analyses = $api->getAnalyses($ProjectUuid)->getAnalyses();
           print_r($analyses);
           die;
//            $response = new Response(json_encode($api->getAnalysis($ProjectUuid, 62)));
//            $response->headers->set('Content-Type', 'application/json');
            
            return $analyses;

            
//        $parameters = array(
//            'USER_UUID' => $userUuid,
//            'API_TOKEN' => $APIToken,
//            'PROJECT_UUID' => $ProjectUuid
//            );
    
            
//        $parameters = array();
//        $url ="https://2022c83d-abdf-4c5d-a612-ad16d55c4da2:b50e050a18ecb16e7ad77eb6cebf29de8830583037b2dacad25f7007d97c2d7e@insight.sensiolabs.com/api/projects/ff6f44ef-e34a-4f9c-aca0-99498f5335dd/analyses";
//       
//

            
//        $output = $this->get('api_caller')->call(new HttpGetJson($url, $parameters));
//        if(!$output)
//        { 
//            var_dump($output);
//            return true;
//        
//        }else {
//            return false;
//        }
      
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//    
//    Usage
//List all projects:
//
//$api->getProjects();
//$api->getProjects(2); // For the second page
//
//Get a project:
//
//$project = $api->getProject('project uuid');
//
//Update a project
//
//$api->updateProject($project);
//
//Note: If something went wrong, see Error management section
//Post a project
//
//use SensioLabs\Insight\Sdk\Model\Project;
//
//$project = new Project();
//$project
//    ->setName('Foo')
//    ->setDescription('Foo')
//    ->setType(TYPE_WEBSITE::TYPE_WEBSITE)
//;
//
//$api->createProject($project)
//
//Note: If something went wrong, see Error management section
//Run an analysis
//
//// on the default branch
//$api->analyze('project uuid', 'origin/master');
//
//// for a specific branch or reference
//$api->analyze('project uuid', 'origin/1.0');
//
//Get all analyses
//
//$api->getAnalyses('project uuid');
//
//Get an analysis
//
//$api->getAnalysis('project uuid', 'analysis id');
//
//Get a status analysis
//
//$api->getAnalysisStatus('project uuid', 'analysis id');
//
//Error management
//
//If something went wrong, an SensioLabs\Insight\Sdk\Exception\ExceptionInterface will be throw:
//
//    ApiClientException If you did something wrong. This exception contains the previous exception throw by guzzle. You can easily check if it is a:
//        403: In this case, check your credentials
//        404: In this case, check your request
//        400: In this case, check the data sent. In this case, the Exception will contains a SensioLabs\Insight\Sdk\Model\Error object. Which will contains all form errors.
//    ApiServerException If something went wrong with the API.
//
//    
    
}
