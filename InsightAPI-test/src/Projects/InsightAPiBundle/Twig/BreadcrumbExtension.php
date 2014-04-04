<?php

namespace Projects\InsightAPiBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BreadcrumbExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'addBreadcrumb' => new \Twig_Function_Method($this, 'addBreadcrumb', array('is_safe' => array('html'))),
            'displayBreadcrumbs' => new \Twig_Function_Method($this, 'displayBreadcrumbs', array('is_safe' => array('html')))
        );
    }

    protected $breadcrumbs = array();

    public function addBreadcrumb(array $breadcrumb, $position = 'first')
    {
        if('first' == $position)
        {
            array_unshift($this->breadcrumbs, $breadcrumb);
        }
        else
        {
            $this->breadcrumbs[] = $breadcrumb;
        }
    }

    public function displayBreadcrumbs(array $breadcrumbs = array())
    {
        if(! sizeof($breadcrumbs))
        {
            $breadcrumbs = $this->breadcrumbs;
        }

        return $this->container->get('templating')->render('ProjectsInsightAPiBundle:Partial:_breadcrumbs.html.twig', array(
            'breadcrumbs' => sizeof($breadcrumbs) ? $breadcrumbs : $this->breadcrumbs
        ));
    }


    public function getName()
    {
        return 'projects_breadcrumb_extension';
    }
}