<?php

namespace App\Modules\Contato\DTO;

class ContatoDTO
{
    public function __construct(
        public bool|null $tipo,
        public string|null $descricao,
        public int|null $idPessoa
    ) {}
}
