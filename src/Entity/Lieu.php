<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'lieu', targetEntity: Personnel::class, orphanRemoval: true)]
    private $personnels;

    public function __construct()
    {
        $this->personnels = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Personnel>
     */
    public function getPersonnels(): Collection
    {
        return $this->personnels;
    }

    public function addPersonnel(Personnel $personnel): self
    {
        if (!$this->personnels->contains($personnel)) {
            $this->personnels[] = $personnel;
            $personnel->setLieu($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): self
    {
        if ($this->personnels->removeElement($personnel)) {
            // set the owning side to null (unless already changed)
            if ($personnel->getLieu() === $this) {
                $personnel->setLieu(null);
            }
        }

        return $this;
    }

    public function getNumberPerGrade(): array {
        $personnels = $this->getPersonnels();
        $grades = [];
        if (is_null($personnels)) return [];
        foreach ($personnels as $personnel)
        {
            array_push($grades, $personnel->getGrade());
        }
        $arrayUniqueElement = [];
        $gradeAndNumber = new ArrayCollection();

        /** @var Grade $grade */
        foreach ($grades as $grade) {
            if (!in_array($grade, $arrayUniqueElement)) {
                $gradeAndNumber->add($grade->setNumber(1));
                array_push($arrayUniqueElement, $grade);
            }
            else {
//                $key = array_search($grade, $gradeAndNumber);
                $key = $gradeAndNumber->indexOf($grade);
                $gradeAndNumber->get($key)->setNumber($gradeAndNumber->get($key)->getNumber() + 1);
            }
        }

        return $gradeAndNumber->toArray();
    }
}
