<?php

namespace App\Modules\Pessoa\Services;

use App\Modules\Pessoa\DTO\PessoaDTO;
use App\Entities\Pessoa;
use App\Modules\Pessoa\Repositories\PessoaRepositoryInterface;

class PessoaService implements PessoaServiceInterface
{
    public function __construct(private PessoaRepositoryInterface $pessoaRepository) {}

    public function listarPessoas(): array
    {
        return $this->pessoaRepository->findAll();
    }

    public function buscarPessoaPorId(int $id): ?Pessoa
    {
        return $this->pessoaRepository->find($id);
    }

    public function criarPessoa(PessoaDTO $pessoaDTO): Pessoa
    {
        $pessoa = new Pessoa();
        $pessoa->setNome($pessoaDTO->nome);
        $pessoa->setCpf($pessoaDTO->cpf);

        return $this->pessoaRepository->save($pessoa);
    }

    public function atualizarPessoa(int $id, PessoaDTO $pessoaDTO): ?Pessoa
    {
        $pessoa = $this->pessoaRepository->find($id);

        if (!$pessoa) {
            return null;
        }

        $pessoa->setNome($pessoaDTO->nome);
        $pessoa->setCpf($pessoaDTO->cpf);

        return $this->pessoaRepository->save($pessoa);
    }

    public function excluirPessoa(int $id): bool
    {
        $pessoa = $this->pessoaRepository->find($id);

        if (!$pessoa) {
            return false;
        }

        $this->pessoaRepository->delete($pessoa);
        return true;
    }
}
