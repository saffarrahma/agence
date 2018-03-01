<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\LocationRepository")
 */
class Location
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="NumPiece", type="integer")
     */
    private $numPiece;

    /**
     * @var string
     *
     * @ORM\Column(name="budget", type="string", length=255)
     */
    private $budget;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="carte", type="string", length=255)
     */
    private $carte;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;

 /******************************************/


    /**
     * @ORM\ManyToOne(targetEntity="Professionel", inversedBy="location")
     * @ORM\JoinColumn(name="professionel_id", referencedColumnName="id")
     */
    private $professionel;

    /**
     * @ORM\ManyToOne(targetEntity="Particulier", inversedBy="location")
     * @ORM\JoinColumn(name="particulier_id", referencedColumnName="id")
     */
    private $particulier;

    /**
     * @ORM\ManyToOne(targetEntity="Association", inversedBy="location")
     * @ORM\JoinColumn(name="association_id", referencedColumnName="id")
     */
    private $association;



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
     * Set type
     *
     * @param string $type
     *
     * @return Location
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set numPiece
     *
     * @param integer $numPiece
     *
     * @return Location
     */
    public function setNumPiece($numPiece)
    {
        $this->numPiece = $numPiece;

        return $this;
    }

    /**
     * Get numPiece
     *
     * @return integer
     */
    public function getNumPiece()
    {
        return $this->numPiece;
    }

    /**
     * Set budget
     *
     * @param string $budget
     *
     * @return Location
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return Location
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set carte
     *
     * @param string $carte
     *
     * @return Location
     */
    public function setCarte($carte)
    {
        $this->carte = $carte;

        return $this;
    }

    /**
     * Get carte
     *
     * @return string
     */
    public function getCarte()
    {
        return $this->carte;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Location
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set professionel
     *
     * @param \Faculte\AdminBundle\Entity\Professionel $professionel
     *
     * @return Location
     */
    public function setProfessionel(\Faculte\AdminBundle\Entity\Professionel $professionel = null)
    {
        $this->professionel = $professionel;

        return $this;
    }

    /**
     * Get professionel
     *
     * @return \Faculte\AdminBundle\Entity\Professionel
     */
    public function getProfessionel()
    {
        return $this->professionel;
    }

    /**
     * Set particulier
     *
     * @param \Faculte\AdminBundle\Entity\Particulier $particulier
     *
     * @return Location
     */
    public function setParticulier(\Faculte\AdminBundle\Entity\Particulier $particulier = null)
    {
        $this->particulier = $particulier;

        return $this;
    }

    /**
     * Get particulier
     *
     * @return \Faculte\AdminBundle\Entity\Particulier
     */
    public function getParticulier()
    {
        return $this->particulier;
    }

    /**
     * Set association
     *
     * @param \Faculte\AdminBundle\Entity\Association $association
     *
     * @return Location
     */
    public function setAssociation(\Faculte\AdminBundle\Entity\Association $association = null)
    {
        $this->association = $association;

        return $this;
    }

    /**
     * Get association
     *
     * @return \Faculte\AdminBundle\Entity\Association
     */
    public function getAssociation()
    {
        return $this->association;
    }
}
