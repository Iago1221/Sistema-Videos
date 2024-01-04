<?php

namespace src\Dominio\Categoria;

interface RepositorioDeCategoria
{
    public function adicionar(Categoria $categoria): Categoria;

    public function buscarPorId(int $categoria): Categoria;

    /** @return Categoria[] */
    public function buscarTodas(int $pagina): array;

    public function deletar(int $id): void;

    public function atualizar(Categoria $categoria): Categoria;
}