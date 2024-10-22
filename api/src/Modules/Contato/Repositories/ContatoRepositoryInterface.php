<?php

namespace App\Modules\Contato\Repositories;

use App\Entities\Contato;

interface ContatoRepositoryInterface
{
    public function findAllByIdPessoa(int $idPessoa): array;
    public function save(Contato $contato): Contato;
    public function find(int $idPessoa, int $id): ?Contato;
    public function delete(Contato $contato): void;
}
