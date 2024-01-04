<?php

namespace src\Aplicacao\Video\AdicionarVideo;

class AdicionarVideoDto
{
    public string $titulo;
    public string $descricao;
    public string $url;

    public int $categoria;

    public function __construct(string $titulo, string $descricao, string $url, int $categoria)
    {

        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->url = $url;
        $this->categoria = $categoria;
    }
}