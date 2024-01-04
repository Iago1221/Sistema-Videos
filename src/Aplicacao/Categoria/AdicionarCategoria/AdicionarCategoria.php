<?php

namespace src\Aplicacao\Categoria\AdicionarCategoria;

use src\Dominio\Categoria\Categoria;
use src\Dominio\Categoria\Cor;
use src\Dominio\Categoria\RepositorioDeCategoria;

class AdicionarCategoria
{
    private RepositorioDeCategoria $repositorioDeCategoria;

    public function __construct(RepositorioDeCategoria $repositorioDeCategoria)
    {
        $this->repositorioDeCategoria = $repositorioDeCategoria;
    }

    public function executa(AdicionarCategoriaDto $dados): Categoria
    {
        $categoria = Categoria::comTituloCorEId($dados->titulo, new Cor($dados->cor));
        return $this->repositorioDeCategoria->adicionar($categoria);
    }
}