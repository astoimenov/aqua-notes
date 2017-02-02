<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenusRepository")
 * @ORM\Table(name="genuses")
 */
class Genus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $subFamily;

    /**
     * @ORM\Column(type="integer")
     */
    private $speciesCount;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $funFact;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = true;

    /**
     * @ORM\OneToMany(targetEntity="GenusNote", mappedBy="genus")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * Gets the value of name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param string $name the name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of subFamily.
     *
     * @return string
     */
    public function getSubFamily()
    {
        return $this->subFamily;
    }

    /**
     * Sets the value of subFamily.
     *
     * @param string $subFamily the sub family
     *
     * @return self
     */
    public function setSubFamily(string $subFamily)
    {
        $this->subFamily = $subFamily;

        return $this;
    }

    /**
     * Gets the value of speciesCount.
     *
     * @return int
     */
    public function getSpeciesCount()
    {
        return $this->speciesCount;
    }

    /**
     * Sets the value of speciesCount.
     *
     * @param int $speciesCount the species count
     *
     * @return self
     */
    public function setSpeciesCount(int $speciesCount)
    {
        $this->speciesCount = $speciesCount;

        return $this;
    }

    /**
     * Gets the value of funFact.
     *
     * @return string
     */
    public function getFunFact()
    {
        return  '**Test**'.$this->funFact;
    }

    /**
     * Sets the value of funFact.
     *
     * @param string $funFact the fun fact
     *
     * @return self
     */
    public function setFunFact(string $funFact)
    {
        $this->funFact = $funFact;

        return $this;
    }

    public function getUpdatedAt()
    {
        return new \DateTime('-'.rand(0, 100).' days');
    }

    /**
     * Gets the value of isPublished.
     *
     * @return bool
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Sets the value of isPublished.
     *
     * @param bool $isPublished the is published
     *
     * @return self
     */
    public function setIsPublished(bool $isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * Gets the value of notes.
     *
     * @return Doctrine\Common\Collections\ArrayCollection|AppBundle\Entity\GenusNote[]
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
