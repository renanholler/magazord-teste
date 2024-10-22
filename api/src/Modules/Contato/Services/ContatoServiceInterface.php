<?php

namespace App\Modules\Contato\Services;

use App\Modules\Contato\DTO\ContatoDTO;
use App\Entities\Contato;

interface ContatoServiceInterface
{
    public function criarContato(ContatoDTO $contatoDTO): ?Contato;
    public function listarContatos(int $idPessoa): array;
    public function buscarContatoPorId(int $idPessoa, int $id): ?Contato;
    public function atualizarContato(int $idPessoa, int $id, ContatoDTO $contatoDTO): ?Contato;
    public function excluirContato(int $idPessoa, int $id): bool;
}
