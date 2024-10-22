<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;

#[ORM\Entity]
#[ORM\Table(name: "pessoa")]
class Pessoa implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string")]
    private string $nome;

    #[ORM\Column(type: "string")]
    private string $cpf;

    #[ORM\OneToMany(mappedBy: "pessoa", targetEntity: Contato::class, cascade: ["persist", "remove"])]
    private Collection $contatos;

    public function __construct()
    {
        $this->contatos = new ArrayCollection();
    }

    // Getters e Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function getContatos(): Collection
    {
        return $this->contatos;
    }

    public function addContato(Contato $contato): void
    {
        if (!$this->contatos->contains($contato)) {
            $this->contatos->add($contato);
            $contato->setPessoa($this);
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf' => $this->cpf
        ];
    }
}
