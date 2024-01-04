<?php

namespace src\Aplicacao\Categoria\BuscarCategoriaPorId;

use src\Dominio\Categoria\Categoria;
use src\Dominio\Categoria\RepositorioDeCategoria;

class BuscarCategoriaPorId
{
    private RepositorioDeCategoria $repositorioDeCategoria;

    public function __construct(RepositorioDeCategoria $repositorioDeCategoria)
    {
        $this->repositorioDeCategoria = $repositorioDeCategoria;
    }

    public function executa(int $id): Categoria
    {
        return $this->repositorioDeCategoria->buscarPorId($id);
    }
}