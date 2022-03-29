<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $video;

    #[ORM\Column(type: 'text')]
    private $explanation;

    #[ORM\ManyToOne(targetEntity: Section::class, inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private $section;

    #[ORM\OneToMany(mappedBy: 'lesson', targetEntity: LessonCheck::class)]
    private $lessonChecks;

    public function __construct()
    {
        $this->lessonChecks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getExplanation(): ?string
    {
        return $this->explanation;
    }

    public function setExplanation(string $explanation): self
    {
        $this->explanation = $explanation;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    /**
     * @return Collection<int, LessonCheck>
     */
    public function getLessonChecks(): Collection
    {
        return $this->lessonChecks;
    }

    public function addLessonCheck(LessonCheck $lessonCheck): self
    {
        if (!$this->lessonChecks->contains($lessonCheck)) {
            $this->lessonChecks[] = $lessonCheck;
            $lessonCheck->setLesson($this);
        }

        return $this;
    }

    public function removeLessonCheck(LessonCheck $lessonCheck): self
    {
        if ($this->lessonChecks->removeElement($lessonCheck)) {
            // set the owning side to null (unless already changed)
            if ($lessonCheck->getLesson() === $this) {
                $lessonCheck->setLesson(null);
            }
        }

        return $this;
    }

    /**
    * Know if user check a lesson
    */
    public function isCheckedByUser(User $user) : bool {
        foreach($this->lessonChecks as $lessonCheck) {            
            if($lessonCheck->getUser() === $user && $lessonCheck->getChecked()) {
                return true;
            }
        }
        return false;
    }
}
