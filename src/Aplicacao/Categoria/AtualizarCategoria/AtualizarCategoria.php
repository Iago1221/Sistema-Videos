<?php

namespace src\Aplicacao\Categoria\AtualizarCategoria;

use src\Dominio\Categoria\Categoria;
use src\Dominio\Categoria\RepositorioDeCategoria;
class AtualizarCategoria
{
    private RepositorioDeCategoria $repositorioDeCategoria;

    public function __construct(RepositorioDeCategoria $repositorioDeCategoria)
    {
        $this->repositorioDeCategoria = $repositorioDeCategoria;
    }

    public function executa(AtualizarCategoriaDto $dados, Categoria $categoria): Categoria
    {
        $categoria->setTitulo($dados->titulo)->setCor($dados->cor);
        return $this->repositorioDeCategoria->atualizar($categoria);
    }
}