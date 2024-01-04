<?php

namespace src\Aplicacao\Categoria\BuscarCategorias;

use src\Dominio\Categoria\RepositorioDeCategoria;

class BuscarCategorias
{
    private RepositorioDeCategoria $repositorioDeCategoria;

    public function __construct(RepositorioDeCategoria $repositorioDeCategoria)
    {
        $this->repositorioDeCategoria = $repositorioDeCategoria;
    }

    /** @return \src\Dominio\Categoria\Categoria[] */
    public function executa(int $pagina)
    {
        return $this->repositorioDeCategoria->buscarTodas($pagina);
    }
}