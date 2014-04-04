<?php

namespace Projects\InsightAPiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Analyses
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projects\InsightAPiBundle\Entity\AnalysesRepository")
 */
class Analyses
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="\Projects\InsightAPiBundle\Entity\Link", mappedBy="analyses")
     **/
    private $links;

    /**
     * @ORM\OneToMany(targetEntity="\Projects\InsightAPiBundle\Entity\Analysis", mappedBy="analyses")
     **/
    private $analyses;
    
     /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

      public function __construct() {
        $this->links= new ArrayCollection();
        $this->analyses= new ArrayCollection();
        $this->createdAt = new \DateTime();
        
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

       
     public function count()
    {
        return count($this->analyses);
    }

   

    /**
     * Add links
     *
     * @param \Projects\InsightAPiBundle\Entity\link $links
     * @return Analyses
     */
    public function addLink(\Projects\InsightAPiBundle\Entity\link $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \Projects\InsightAPiBundle\Entity\link $links
     */
    public function removeLink(\Projects\InsightAPiBundle\Entity\link $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
    }

   
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Analyses
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Add analyses
     *
     * @param \Projects\InsightAPiBundle\Entity\Analysis $analyses
     * @return Analyses
     */
    public function addAnalysis(\Projects\InsightAPiBundle\Entity\Analysis $analyses)
    {
        $this->analyses[] = $analyses;

        return $this;
    }

    /**
     * Remove analyses
     *
     * @param \Projects\InsightAPiBundle\Entity\Analysis $analyses
     */
    public function removeAnalysis(\Projects\InsightAPiBundle\Entity\Analysis $analyses)
    {
        $this->analyses->removeElement($analyses);
    }

    /**
     * Get analyses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnalyses()
    {
        return $this->analyses;
    }
}
