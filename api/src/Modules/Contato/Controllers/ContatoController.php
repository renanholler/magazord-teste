<?php

namespace App\Modules\Contato\Controllers;

use App\Core\Route;
use App\Modules\Contato\Services\ContatoServiceInterface;
use App\Modules\Contato\DTO\ContatoDTO;
use App\Core\Controllers\ControllerBase;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class ContatoController extends ControllerBase
{
    public function __construct(private ContatoServiceInterface $contatoService) {}

    #[Route('GET', '/contatos/{idPessoa}')]
    public function index(ServerRequestInterface $request, int $idPessoa): Response
    {
        $contatos = $this->contatoService->listarContatos($idPessoa);
        return $this->jsonResponse(200, $contatos);
    }

    #[Route('GET', '/contatos/{idPessoa}/{id}')]
    public function show(ServerRequestInterface $request, int $idPessoa, int $id): Response
    {
        $contato = $this->contatoService->buscarContatoPorId($idPessoa, $id);

        if (!$contato) {
            return $this->jsonResponse(404, ['message' => 'Contato não encontrado.']);
        }

        return $this->jsonResponse(200, $contato);
    }

    #[Route('POST', '/contatos/{idPessoa}')]
    public function store(ServerRequestInterface $request, int $idPessoa): Response
    {
        $data = $this->getParsedBody($request);

        if (!$this->validarDados($data, ['tipo', 'descricao'])) {
            return $this->jsonResponse(400, ['message' => 'Dados incompletos.']);
        }

        $contatoDTO = new ContatoDTO($data['tipo'], $data['descricao'], $idPessoa);
        $contato = $this->contatoService->criarContato($contatoDTO);

        return $this->jsonResponse(201, [
            'tipo' => $contato->getTipo(),
            'descricao' => $contato->getDescricao(),
            'idPessoa' => $contato->getPessoa()->getId()
        ]);
    }

    #[Route('PATCH', '/contatos/{idPessoa}/{id}')]
    public function update(ServerRequestInterface $request, int $idPessoa, int $id): Response
    {
        $data = $this->getParsedBody($request);

        $contatoDTO = new ContatoDTO(
            $data['tipo'] ?? null,
            $data['descricao'] ?? null,
            null
        );
        $contato = $this->contatoService->atualizarContato($idPessoa, $id, $contatoDTO);

        if (!$contato) {
            return $this->jsonResponse(404, ['message' => 'Contato não encontrado.']);
        }

        return $this->jsonResponse(200, [
            'tipo' => $contato->getTipo(),
            'descricao' => $contato->getDescricao(),
            'idPessoa' => $contato->getPessoa()->getId()
        ]);
    }

    #[Route('DELETE', '/contatos/{idPessoa}/{id}')]
    public function delete(ServerRequestInterface $request, int $idPessoa, int $id): Response
    {
        $sucesso = $this->contatoService->excluirContato($idPessoa, $id);

        if (!$sucesso) {
            return $this->jsonResponse(404, ['message' => 'Contato não encontrado.']);
        }

        return $this->jsonResponse(200, ['message' => 'Contato excluído com sucesso.']);
    }
}
