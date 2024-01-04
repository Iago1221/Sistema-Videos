<?php

namespace src\Dominio\Video;

use src\Dominio\Categoria\Categoria;

interface RepositorioDeVideo
{
    public function adicionar(Video $video): Video;

    public function buscarPorId(int $id): Video;

    /** @return Video[] */
    public function buscarTodos(string $search = null, int $pagina): array;

    public function deletar(int $id): void;

    public function atualizar(Video $video): Video;

    public function buscarVideosPorCategoria(Categoria $categoria, int $pagina): array;
}