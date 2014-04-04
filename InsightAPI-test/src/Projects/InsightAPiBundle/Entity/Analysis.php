<?php

namespace Projects\InsightAPiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Analysis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projects\InsightAPiBundle\Entity\AnalysisRepository")
 */
class Analysis
{
    // static status
    const STATUS_ORDERED  = 'ordered';
    const STATUS_RUNNING  = 'running';
    const STATUS_MEASURED = 'measured';
    const STATUS_ANALYZED = 'analyzed';
    const STATUS_FINISHED = 'finished';
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Projects\InsightAPiBundle\Entity\Analyses", inversedBy="analyses")
     * @ORM\JoinColumn(name="analyses_id", referencedColumnName="id")
     **/
    private $analyses;

     /**
     * @ORM\OneToMany(targetEntity="\Projects\InsightAPiBundle\Entity\Link", mappedBy="analysis")
     **/
    private $links;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="grade", type="string", length=8)
     */
    private $grade;

    /**
     * @var string
     *
     * @ORM\Column(name="nextGrade", type="string", length=8)
     */
    private $nextGrade;

    /**
     * @var array
     *
     * @ORM\Column(name="grades", type="array")
     */
    private $grades;

    /**
     * @var float
     *
     * @ORM\Column(name="remediationCost", type="float")
     */
    private $remediationCost;

    /**
     * @var float
     *
     * @ORM\Column(name="remediationCostForNextGrade", type="float")
     */
    private $remediationCostForNextGrade;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbViolations", type="integer")
     */
    private $nbViolations;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="beginAt", type="datetime")
     */
    private $beginAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endAt", type="datetime")
     */
    private $endAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="failureMessage", type="string", length=255, nullable=true)
     */
    private $failureMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="failureCode", type="string", length=255, nullable=true)
     */
    private $failureCode;

    /**
     * @var boolean
     *
     * @ORM\Column(name="failed", type="boolean")
     */
    private $failed;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20)
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isAltered", type="boolean")
     */
    private $isAltered;

    /**
     * @ORM\OneToMany(targetEntity="Projects\InsightAPiBundle\Entity\Violations", mappedBy="analysis")
     **/
    private $violations;
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

        
         public function __construct()
    {
        $this->violations = new \Doctrine\Common\Collections\ArrayCollection();
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


    /**
     * Set number
     *
     * @param integer $number
     * @return Analysis
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set grade
     *
     * @param string $grade
     * @return Analysis
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return string 
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set nextGrade
     *
     * @param string $nextGrade
     * @return Analysis
     */
    public function setNextGrade($nextGrade)
    {
        $this->nextGrade = $nextGrade;

        return $this;
    }

    /**
     * Get nextGrade
     *
     * @return string 
     */
    public function getNextGrade()
    {
        return $this->nextGrade;
    }

    /**
     * Set grades
     *
     * @param array $grades
     * @return Analysis
     */
    public function setGrades($grades)
    {
        $this->grades = $grades;

        return $this;
    }

    /**
     * Get grades
     *
     * @return array 
     */
    public function getGrades()
    {
        return $this->grades;
    }

    /**
     * Set remediationCost
     *
     * @param float $remediationCost
     * @return Analysis
     */
    public function setRemediationCost($remediationCost)
    {
        $this->remediationCost = $remediationCost;

        return $this;
    }

    /**
     * Get remediationCost
     *
     * @return float 
     */
    public function getRemediationCost()
    {
        return $this->remediationCost;
    }

    /**
     * Set remediationCostForNextGrade
     *
     * @param float $remediationCostForNextGrade
     * @return Analysis
     */
    public function setRemediationCostForNextGrade($remediationCostForNextGrade)
    {
        $this->remediationCostForNextGrade = $remediationCostForNextGrade;

        return $this;
    }

    /**
     * Get remediationCostForNextGrade
     *
     * @return float 
     */
    public function getRemediationCostForNextGrade()
    {
        return $this->remediationCostForNextGrade;
    }

    /**
     * Set nbViolations
     *
     * @param integer $nbViolations
     * @return Analysis
     */
    public function setNbViolations($nbViolations)
    {
        $this->nbViolations = $nbViolations;

        return $this;
    }

    /**
     * Get nbViolations
     *
     * @return integer 
     */
    public function getNbViolations()
    {
        return $this->nbViolations;
    }

    /**
     * Set beginAt
     *
     * @param \DateTime $beginAt
     * @return Analysis
     */
    public function setBeginAt($beginAt)
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    /**
     * Get beginAt
     *
     * @return \DateTime 
     */
    public function getBeginAt()
    {
        return $this->beginAt;
    }

    /**
     * Set endAt
     *
     * @param \DateTime $endAt
     * @return Analysis
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt
     *
     * @return \DateTime 
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Analysis
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set failureMessage
     *
     * @param string $failureMessage
     * @return Analysis
     */
    public function setFailureMessage($failureMessage)
    {
        $this->failureMessage = $failureMessage;

        return $this;
    }

    /**
     * Get failureMessage
     *
     * @return string 
     */
    public function getFailureMessage()
    {
        return $this->failureMessage;
    }

    /**
     * Set failureCode
     *
     * @param string $failureCode
     * @return Analysis
     */
    public function setFailureCode($failureCode)
    {
        $this->failureCode = $failureCode;

        return $this;
    }

    /**
     * Get failureCode
     *
     * @return string 
     */
    public function getFailureCode()
    {
        return $this->failureCode;
    }

    /**
     * Set failed
     *
     * @param boolean $failed
     * @return Analysis
     */
    public function setFailed($failed)
    {
        $this->failed = $failed;

        return $this;
    }

    /**
     * Get failed
     *
     * @return boolean 
     */
    public function getFailed()
    {
        return $this->failed;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Analysis
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isAltered
     *
     * @param boolean $isAltered
     * @return Analysis
     */
    public function setIsAltered($isAltered)
    {
        $this->isAltered = $isAltered;

        return $this;
    }

    /**
     * Get isAltered
     *
     * @return boolean 
     */
    public function getIsAltered()
    {
        return $this->isAltered;
    }


     public function isFinished()
    {
        return static::STATUS_FINISHED == $this->status;
    }

    

    
    /**
     * Constructor
     */
   

    /**
     * Add violations
     *
     * @param \Projects\InsightAPiBundle\Entity\Violations $violations
     * @return Analysis
     */
    public function addViolation(\Projects\InsightAPiBundle\Entity\Violations $violations)
    {
        $this->violations[] = $violations;

        return $this;
    }

    /**
     * Remove violations
     *
     * @param \Projects\InsightAPiBundle\Entity\Violations $violations
     */
    public function removeViolation(\Projects\InsightAPiBundle\Entity\Violations $violations)
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
     * @return Analysis
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
     * Set analyses
     *
     * @param \Projects\InsightAPiBundle\Entity\Analyses $analyses
     * @return Analysis
     */
    public function setAnalyses(\Projects\InsightAPiBundle\Entity\Analyses $analyses = null)
    {
        $this->analyses = $analyses;

        return $this;
    }

    /**
     * Get analyses
     *
     * @return \Projects\InsightAPiBundle\Entity\Analyses 
     */
    public function getAnalyses()
    {
        return $this->analyses;
    }

   

    /**
     * Add links
     *
     * @param \Projects\InsightAPiBundle\Entity\link $links
     * @return Analysis
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
}
