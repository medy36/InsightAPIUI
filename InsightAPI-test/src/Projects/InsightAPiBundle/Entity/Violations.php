<?php

namespace Projects\InsightAPiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Violations
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projects\InsightAPiBundle\Entity\ViolationsRepository")
 */
class Violations
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
     * @ORM\ManyToOne(targetEntity="Projects\InsightAPiBundle\Entity\Analysis", inversedBy="violations")
     * @ORM\JoinColumn(name="analysis_id", referencedColumnName="id")
     **/
    private $analysis;

    /**
     * @ORM\OneToMany(targetEntity="Projects\InsightAPiBundle\Entity\Violation", mappedBy="violations")
     **/
    private $violations;


    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

        
      
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
        return count($this->violations);
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->violations = new \Doctrine\Common\Collections\ArrayCollection();
         $this->createdAt = new \DateTime();
    }

    /**
     * Set analysis
     *
     * @param \Projects\InsightAPiBundle\Entity\Analysis $analysis
     * @return Violations
     */
    public function setAnalysis(\Projects\InsightAPiBundle\Entity\Analysis $analysis = null)
    {
        $this->analysis = $analysis;

        return $this;
    }

    /**
     * Get analysis
     *
     * @return \Projects\InsightAPiBundle\Entity\Analysis 
     */
    public function getAnalysis()
    {
        return $this->analysis;
    }

    /**
     * Add violations
     *
     * @param \Projects\InsightAPiBundle\Entity\Violation $violations
     * @return Violations
     */
    public function addViolation(\Projects\InsightAPiBundle\Entity\Violation $violations)
    {
        $this->violations[] = $violations;

        return $this;
    }

    /**
     * Remove violations
     *
     * @param \Projects\InsightAPiBundle\Entity\Violation $violations
     */
    public function removeViolation(\Projects\InsightAPiBundle\Entity\Violation $violations)
    {
        $this->violations->removeElement($violations);
    }

    /**
     * Get violations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Violations
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
}
