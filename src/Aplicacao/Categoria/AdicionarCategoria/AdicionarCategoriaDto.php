<?php

namespace src\Aplicacao\Categoria\AdicionarCategoria;

class AdicionarCategoriaDto
{
    public string $titulo;
    public int $cor;

    public function __construct(string $titulo, int $cor)
    {
        $this->titulo = $titulo;
        $this->cor = $cor;
    }
}