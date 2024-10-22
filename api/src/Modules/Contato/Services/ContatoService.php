<?php

namespace App\Modules\Contato\Services;

use App\Modules\Contato\DTO\ContatoDTO;
use App\Modules\Contato\Repositories\ContatoRepositoryInterface;
use App\Entities\Contato;
use App\Entities\Pessoa;
use Doctrine\ORM\EntityManagerInterface;

class ContatoService implements ContatoServiceInterface
{
    public function __construct(private ContatoRepositoryInterface $contatoRepository, private EntityManagerInterface $em) {}

    public function criarContato(ContatoDTO $contatoDTO): ?Contato
    {
        $pessoa = $this->em->getRepository(Pessoa::class)->find($contatoDTO->idPessoa);

        if (!$pessoa) {
            throw new \Exception('Pessoa não encontrada para o ID: ' . $contatoDTO->idPessoa);
        }

        $contato = new Contato();
        $contato->setTipo($contatoDTO->tipo);
        $contato->setDescricao($contatoDTO->descricao);
        $contato->setPessoa($pessoa);

        $this->contatoRepository->save($contato);

        return $contato;
    }

    public function listarContatos(int $idPessoa): array
    {
        $contatos = $this->contatoRepository->findAllByIdPessoa($idPessoa);

        return array_map(function (Contato $c) {
            return [
                'id' => $c->getId(),
                'tipo' => $c->getTipo(),
                'descricao' => $c->getDescricao(),
                'pessoa_id' => $c->getPessoa()->getId()
            ];
        }, $contatos);
    }

    public function buscarContatoPorId(int $idPessoa, int $id): ?Contato
    {
        return $this->contatoRepository->find($idPessoa, $id);
    }

    public function atualizarContato(int $idPessoa, int $id, ContatoDTO $contatoDTO): ?Contato
    {
        // Buscar o contato com base no idPessoa e no id do contato
        $contato = $this->contatoRepository->find($idPessoa, $id);

        if (!$contato) {
            return null;
        }

        // Atualizar os dados do contato
        isset($contatoDTO->tipo) && $contato->setTipo($contatoDTO->tipo);
        isset($contatoDTO->descricao) && $contato->setDescricao($contatoDTO->descricao);

        $this->contatoRepository->save($contato);

        return $contato;
    }

    public function excluirContato(int $idPessoa, int $id): bool
    {
        // Buscar o contato com base no idPessoa e no id do contato
        $contato = $this->contatoRepository->find($idPessoa, $id);

        if (!$contato) {
            return false;
        }

        // Excluir o contato
        $this->contatoRepository->delete($contato);

        return true;
    }
}
