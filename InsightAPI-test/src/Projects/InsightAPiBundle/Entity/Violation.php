<?php

namespace Projects\InsightAPiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Violation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Projects\InsightAPiBundle\Entity\ViolationRepository")
 */
class Violation
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="resource", type="string", length=255, nullable= true)
     */
    private $resource;

    /**
     * @var integer
     *
     * @ORM\Column(name="line", type="integer", nullable= true)
     */
    private $line;

    /**
     * @var string
     *
     * @ORM\Column(name="severity", type="string", length=30)
     */
    private $severity;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=20)
     */
    private $category;
    
     /**
     * @ORM\ManyToOne(targetEntity="Projects\InsightAPiBundle\Entity\Violations", inversedBy="violations")
     * @ORM\JoinColumn(name="violations_id", referencedColumnName="id")
     **/
    private $violations;

     /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    
    /**
     * Constructor
     */
    public function __construct()
    {
 
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
     * Set title
     *
     * @param string $title
     * @return Violation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Violation
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set resource
     *
     * @param string $resource
     * @return Violation
     */
    public function setResource($resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return string 
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set line
     *
     * @param integer $line
     * @return Violation
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get line
     *
     * @return integer 
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Set severity
     *
     * @param string $severity
     * @return Violation
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;

        return $this;
    }

    /**
     * Get severity
     *
     * @return string 
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Violation
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set violations
     *
     * @param \Projects\InsightAPiBundle\Entity\Violations $violations
     * @return Violation
     */
    public function setViolations(\Projects\InsightAPiBundle\Entity\Violations $violations = null)
    {
        $this->violations = $violations;

        return $this;
    }

    /**
     * Get violations
     *
     * @return \Projects\InsightAPiBundle\Entity\Violations 
     */
    public function getViolations()
    {
        return $this->violations;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Violation
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
