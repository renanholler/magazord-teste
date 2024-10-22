<?php

namespace App\Modules\Pessoa\DTO;

class PessoaDTO
{
    public function __construct(
        public string $nome,
        public string $cpf
    ) {}
}
