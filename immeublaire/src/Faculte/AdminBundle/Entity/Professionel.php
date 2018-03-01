<?php

namespace Faculte\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professionel
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="professionel")
 * @ORM\Entity(repositoryClass="Faculte\AdminBundle\Repository\ProfessionelRepository")
 */
class Professionel
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
     * @ORM\Column(name="denomination", type="string", length=255)
     */
    private $denomination;

    /**
     * @var string
     *
     * @ORM\Column(name="presenter", type="string", length=255)
     */
    private $presenter;



    /**
     * @var string
     *
     * @ORM\Column(name="organisation", type="string", length=255)
     */
    private $organisation;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="codepostal", type="string", length=255,nullable=true)
     */
    private $codepostal;


    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="portable", type="string", length=255,nullable=true)
     */
    private $portable;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255,nullable=true)
     */
    private $fax;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;
    /**
     * @var string
     *
     * @ORM\Column(name="path_file", type="string", length=255,nullable=true)
     */
    private $pathFile;


    public function getFullPathFilePath() {
        return null === $this->pathFile ? null : $this->getUploadPathFileRootDir(). $this->pathFile;
    }

    public function getUploadPathFileRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadPathFileRootDir()."/".$this->getId()."/";
    }

    public function getTmpUploadPathFileRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/files/logoSte/';
    }

    public function getExtensionPathFile() {

        $name = strtr($this->pathFile->getClientOriginalName(),
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $name = preg_replace('/([^.a-z0-9]+)/i', '-', $name);

        $ext = strtolower(substr($name, strrpos($name, '.'))); // extension du fichier
        return  $ext;
    }

    public function uploadPathFile() {

        // the file property can be empty if the field is not required
        if (null === $this->pathFile) {
            return;
        }

        $name = strtr($this->pathFile->getClientOriginalName(),
            'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
            'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        $name = preg_replace('/([^.a-z0-9]+)/i', '-', $name);

        if(!$this->getId()){
            $this->pathFile->move($this->getTmpUploadPathFileRootDir(), $name);
        }else{
            $this->pathFile->move($this->getUploadPathFileRootDir(), $name);
        }

        $this->setPathFile($name);

    }


    public function movePathFile()
    {
        if (null === $this->pathFile) {
            return;
        }

        if(!is_dir($this->getUploadPathFileRootDir())){
            mkdir($this->getUploadPathFileRootDir());
        }
        copy($this->getTmpUploadPathFileRootDir().$this->pathFile, $this->getFullPathFilePath());
        unlink($this->getTmpUploadPathFileRootDir().$this->pathFile);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removePathFile()
    {
        if(file_exists($this->getFullPathFilePath())){
            unlink($this->getFullPathFilePath());
            //rmdir($this->getUploadPathFileRootDir());
        }

    }

    /**************************************/
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="professionel")
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id")
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="professionel",cascade={"remove"})
     *
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity="Vente", mappedBy="professionel",cascade={"remove"})
     *
     */
    private $ventes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->locations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Convert object to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getDenomination();

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
     * Set denomination
     *
     * @param string $denomination
     *
     * @return Professionel
     */
    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get denomination
     *
     * @return string
     */
    public function getDenomination()
    {
        return $this->denomination;
    }

    /**
     * Set presenter
     *
     * @param string $presenter
     *
     * @return Professionel
     */
    public function setPresenter($presenter)
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * Get presenter
     *
     * @return string
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * Set organisation
     *
     * @param string $organisation
     *
     * @return Professionel
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;

        return $this;
    }

    /**
     * Get organisation
     *
     * @return string
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }

    /**
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Professionel
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Professionel
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set codepostal
     *
     * @param string $codepostal
     *
     * @return Professionel
     */
    public function setCodepostal($codepostal)
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    /**
     * Get codepostal
     *
     * @return string
     */
    public function getCodepostal()
    {
        return $this->codepostal;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Professionel
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set portable
     *
     * @param string $portable
     *
     * @return Professionel
     */
    public function setPortable($portable)
    {
        $this->portable = $portable;

        return $this;
    }

    /**
     * Get portable
     *
     * @return string
     */
    public function getPortable()
    {
        return $this->portable;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Professionel
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Professionel
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set pathFile
     *
     * @param string $pathFile
     *
     * @return Professionel
     */
    public function setPathFile($pathFile)
    {
        $this->pathFile = $pathFile;

        return $this;
    }

    /**
     * Get pathFile
     *
     * @return string
     */
    public function getPathFile()
    {
        return $this->pathFile;
    }

    /**
     * Set user
     *
     * @param \Faculte\AdminBundle\Entity\User $user
     *
     * @return Professionel
     */
    public function setUser(\Faculte\AdminBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Faculte\AdminBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set ville
     *
     * @param \Faculte\AdminBundle\Entity\Ville $ville
     *
     * @return Professionel
     */
    public function setVille(\Faculte\AdminBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Faculte\AdminBundle\Entity\Ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Add location
     *
     * @param \Faculte\AdminBundle\Entity\Location $location
     *
     * @return Professionel
     */
    public function addLocation(\Faculte\AdminBundle\Entity\Location $location)
    {
        $this->locations[] = $location;

        return $this;
    }

    /**
     * Remove location
     *
     * @param \Faculte\AdminBundle\Entity\Location $location
     */
    public function removeLocation(\Faculte\AdminBundle\Entity\Location $location)
    {
        $this->locations->removeElement($location);
    }

    /**
     * Get locations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * Add vente
     *
     * @param \Faculte\AdminBundle\Entity\Vente $vente
     *
     * @return Professionel
     */
    public function addVente(\Faculte\AdminBundle\Entity\Vente $vente)
    {
        $this->ventes[] = $vente;

        return $this;
    }

    /**
     * Remove vente
     *
     * @param \Faculte\AdminBundle\Entity\Vente $vente
     */
    public function removeVente(\Faculte\AdminBundle\Entity\Vente $vente)
    {
        $this->ventes->removeElement($vente);
    }

    /**
     * Get ventes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVentes()
    {
        return $this->ventes;
    }
}
