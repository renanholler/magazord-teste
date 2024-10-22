<?php

namespace App\Modules\Pessoa\Controllers;

use App\Core\Route;
use App\Modules\Pessoa\Services\PessoaServiceInterface;
use App\Modules\Pessoa\DTO\PessoaDTO;
use App\Core\Controllers\ControllerBase;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class PessoaController extends ControllerBase
{
    public function __construct(private PessoaServiceInterface $pessoaService) {}

    #[Route('GET', '/pessoas')]
    public function index(): Response
    {
        $pessoas = $this->pessoaService->listarPessoas();
        return $this->jsonResponse(200, $pessoas);
    }

    #[Route('GET', '/pessoas/{id}')]
    public function show(ServerRequestInterface $request, int $id): Response
    {
        $pessoa = $this->pessoaService->buscarPessoaPorId($id);

        if (!$pessoa) {
            return $this->jsonResponse(404, ['message' => 'Pessoa não encontrada.']);
        }

        return $this->jsonResponse(200, $pessoa);
    }

    #[Route('POST', '/pessoas')]
    public function store(ServerRequestInterface $request): Response
    {
        $data = $this->getParsedBody($request);

        if (!$this->validarDados($data, ['nome', 'cpf'])) {
            return $this->jsonResponse(400, ['message' => 'Dados incompletos.']);
        }

        $pessoaDTO = new PessoaDTO($data['nome'], $data['cpf']);
        $pessoa = $this->pessoaService->criarPessoa($pessoaDTO);

        return $this->jsonResponse(201, [
            'id' => $pessoa->getId(),
            'nome' => $pessoa->getNome(),
            'cpf' => $pessoa->getCpf()
        ]);
    }

    #[Route('PUT', '/pessoas/{id}')]
    public function update(ServerRequestInterface $request, int $id): Response
    {
        $data = $this->getParsedBody($request);

        $pessoaDTO = new PessoaDTO($data['nome'], $data['cpf']);
        $pessoa = $this->pessoaService->atualizarPessoa($id, $pessoaDTO);

        if (!$pessoa) {
            return $this->jsonResponse(404, ['message' => 'Pessoa não encontrada.']);
        }

        return $this->jsonResponse(200, [
            'id' => $pessoa->getId(),
            'nome' => $pessoa->getNome(),
            'cpf' => $pessoa->getCpf()
        ]);
    }

    #[Route('DELETE', '/pessoas/{id}')]
    public function delete(ServerRequestInterface $request, int $id): Response
    {
        $sucesso = $this->pessoaService->excluirPessoa($id);

        if (!$sucesso) {
            return $this->jsonResponse(404, ['message' => 'Pessoa não encontrada.']);
        }

        return $this->jsonResponse(200, ['message' => 'Pessoa excluída com sucesso.']);
    }
}
