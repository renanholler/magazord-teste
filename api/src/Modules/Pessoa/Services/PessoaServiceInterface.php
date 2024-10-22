<?php

namespace App\Modules\Pessoa\Services;

use App\Modules\Pessoa\DTO\PessoaDTO;
use App\Entities\Pessoa;

interface PessoaServiceInterface
{
    public function criarPessoa(PessoaDTO $pessoaDTO): Pessoa;
    public function listarPessoas(): array;
    public function buscarPessoaPorId(int $id): ?Pessoa;
    public function atualizarPessoa(int $id, PessoaDTO $pessoaDTO): ?Pessoa;
    public function excluirPessoa(int $id): bool;
}
