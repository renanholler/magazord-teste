<?php

namespace App\Core\Controllers;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class ControllerBase
{
    /**
     * Método auxiliar para criar respostas JSON.
     */
    protected final function jsonResponse(int $status, array|object $data): Response
    {
        return new Response(
            $status,
            ['Content-Type' => 'application/json'],
            json_encode($data)
        );
    }

    /**
     * Método auxiliar para validar dados.
     */
    protected final function validarDados(array $data, array $camposObrigatorios): bool
    {
        foreach ($camposObrigatorios as $campo) {
            if (!isset($data[$campo])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Método para recuperar o body da requisição e transformar em array.
     */
    protected final function getParsedBody(ServerRequestInterface $request)
    {
        $rawBody = (string)$request->getBody();
        return json_decode($rawBody, true);
    }
}
