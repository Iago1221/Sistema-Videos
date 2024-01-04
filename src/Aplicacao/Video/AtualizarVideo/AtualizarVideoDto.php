<?php

namespace src\Aplicacao\Video\AtualizarVideo;

class AtualizarVideoDto
{
    public int $id;
    public string $titulo;
    public string $descricao;
    public string $url;
    public int $categoria;

    public function __construct(int $id, string $titulo, string $descricao, string $url, int $categoria)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->url = $url;
        $this->categoria = $categoria;
    }
}