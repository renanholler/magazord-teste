<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "contato")]
class Contato
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "boolean")]
    private bool $tipo;

    #[ORM\Column(type: "string")]
    private string $descricao;

    #[ORM\ManyToOne(targetEntity: Pessoa::class, inversedBy: "contatos")]
    #[ORM\JoinColumn(name: "idPessoa", referencedColumnName: "id")]
    private Pessoa $pessoa;

    // Getters e Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): bool
    {
        return $this->tipo;
    }

    public function setTipo(bool $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getPessoa(): Pessoa
    {
        return $this->pessoa;
    }

    public function setPessoa(Pessoa $pessoa): void
    {
        $this->pessoa = $pessoa;
    }
}
