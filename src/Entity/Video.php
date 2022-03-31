<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Uploadable
 */
#[ORM\Entity(repositoryClass: VideoRepository::class)]

class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentary;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $link = null;

    #[ORM\Column(type: 'boolean')]
    private $published;

    #[ORM\Column(type: 'string', length: 255)]
    private $falseResponseOne;

    #[ORM\Column(type: 'string', length: 255)]
    private $falseResponseTwo;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'videos')]
    private $category;

    #[ORM\OneToMany(mappedBy: 'video', targetEntity: Answer::class)]
    private $answers;

    /**
     * @UploadableField(mapping="videos", fileNameProperty="link")
     */
    private ?File $file = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
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

    public function getCommentary(): ?string
    {
        return $this->commentary;
    }

    public function setCommentary(?string $commentary): self
    {
        $this->commentary = $commentary;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getFalseResponseOne(): ?string
    {
        return $this->falseResponseOne;
    }

    public function setFalseResponseOne(string $falseResponseOne): self
    {
        $this->falseResponseOne = $falseResponseOne;

        return $this;
    }

    public function getFalseResponseTwo(): ?string
    {
        return $this->falseResponseTwo;
    }

    public function setFalseResponseTwo(string $falseResponseTwo): self
    {
        $this->falseResponseTwo = $falseResponseTwo;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setVideo($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getVideo() === $this) {
                $answer->setVideo(null);
            }
        }

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): void
    {
        $this->file = $file;
    }
}
