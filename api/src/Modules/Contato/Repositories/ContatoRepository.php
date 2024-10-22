<?php

namespace App\Modules\Contato\Repositories;

use App\Entities\Contato;
use App\Entities\Pessoa;
use Doctrine\ORM\EntityManagerInterface;

class ContatoRepository implements ContatoRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function findAllByIdPessoa(int $idPessoa): array
    {
        $pessoa = $this->entityManager->getRepository(Pessoa::class)->find($idPessoa);
        return $this->entityManager->getRepository(Contato::class)->findBy(['pessoa' => $pessoa]);
    }

    public function find(int $idPessoa, int $id): ?Contato
    {
        $pessoa = $this->entityManager->getRepository(Pessoa::class)->find($idPessoa);
        return $this->entityManager->getRepository(Contato::class)->findOneBy(['pessoa' => $pessoa, 'id' => $id]);
    }

    public function save(Contato $contato): Contato
    {
        $this->entityManager->persist($contato);
        $this->entityManager->flush();
        return $contato;
    }

    public function delete(Contato $contato): void
    {
        $this->entityManager->remove($contato);
        $this->entityManager->flush();
    }
}
