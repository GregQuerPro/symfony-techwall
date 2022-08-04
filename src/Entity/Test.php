<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "json", nullable: true, options : ['jsonb' => true])]
    private array $testjsonb = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestjsonb(): array
    {
        return $this->testjsonb;
    }

    public function setTestjsonb(?array $testjsonb): self
    {
        $this->testjsonb = $testjsonb;

        return $this;
    }
}
