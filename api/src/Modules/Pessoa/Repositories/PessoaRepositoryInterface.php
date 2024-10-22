<?php

namespace App\Modules\Pessoa\Repositories;

use App\Entities\Pessoa;

interface PessoaRepositoryInterface
{
    public function findAll(): array;
    public function find(int $id): ?Pessoa;
    public function save(Pessoa $pessoa): Pessoa;
    public function delete(Pessoa $pessoa): void;
}
