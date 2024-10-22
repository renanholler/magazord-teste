<?php

namespace App\Modules\Pessoa\Repositories;

use App\Entities\Pessoa;
use Doctrine\ORM\EntityManagerInterface;

class PessoaRepository implements PessoaRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Pessoa::class)->findAll();
    }

    public function find(int $id): ?Pessoa
    {
        return $this->entityManager->getRepository(Pessoa::class)->find($id);
    }

    public function save(Pessoa $pessoa): Pessoa
    {
        $this->entityManager->persist($pessoa);
        $this->entityManager->flush();
        return $pessoa;
    }

    public function delete(Pessoa $pessoa): void
    {
        $this->entityManager->remove($pessoa);
        $this->entityManager->flush();
    }
}
