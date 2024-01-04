<?php

namespace src\Aplicacao\Categoria\DeletarCategoria;

use src\Dominio\Categoria\RepositorioDeCategoria;

class DeletarCategoria
{
    private RepositorioDeCategoria $repositorioDeCategoria;

    public function __construct(RepositorioDeCategoria $repositorioDeCategoria)
    {
        $this->repositorioDeCategoria = $repositorioDeCategoria;
    }

    public function executa(int $id): void
    {
        $this->repositorioDeCategoria->deletar($id);
    }
}