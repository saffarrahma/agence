<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\VilleRepository")
 */
class Ville
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
     * @ORM\Column(name="Ville", type="string", length=255)
     */
    private $ville;


    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="ville")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;


    /**
     * @ORM\OneToMany(targetEntity="Professionel", mappedBy="ville",cascade={"remove"})
     *
     */
    private $professionels;



    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getVille();
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->professionels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set ville
     *
     * @param string $ville
     *
     * @return Ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set region
     *
     * @param \Faculte\AdminBundle\Entity\Region $region
     *
     * @return Ville
     */
    public function setRegion(\Faculte\AdminBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Faculte\AdminBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add professionel
     *
     * @param \Faculte\AdminBundle\Entity\Professionel $professionel
     *
     * @return Ville
     */
    public function addProfessionel(\Faculte\AdminBundle\Entity\Professionel $professionel)
    {
        $this->professionels[] = $professionel;

        return $this;
    }

    /**
     * Remove professionel
     *
     * @param \Faculte\AdminBundle\Entity\Professionel $professionel
     */
    public function removeProfessionel(\Faculte\AdminBundle\Entity\Professionel $professionel)
    {
        $this->professionels->removeElement($professionel);
    }

    /**
     * Get professionels
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProfessionels()
    {
        return $this->professionels;
    }
}
