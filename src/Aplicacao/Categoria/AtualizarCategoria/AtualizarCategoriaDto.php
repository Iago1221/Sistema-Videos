<?php

namespace src\Aplicacao\Categoria\AtualizarCategoria;

class AtualizarCategoriaDto
{
    public int $id;
    public string $titulo;
    public int $cor;

    public function __construct(int $id, string $titulo, string $cor)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->cor = $cor;
    }
}