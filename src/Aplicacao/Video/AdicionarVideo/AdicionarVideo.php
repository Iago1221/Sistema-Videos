<?php

namespace src\Aplicacao\Video\AdicionarVideo;

use src\Dominio\Categoria\RepositorioDeCategoria;
use src\Dominio\Video\RepositorioDeVideo;
use src\Dominio\Video\Url;
use src\Dominio\Video\Video;

class AdicionarVideo
{
    private RepositorioDeVideo $repositorioDeVideo;
    private RepositorioDeCategoria $repositorioDeCategoria;

    public function __construct(RepositorioDeVideo $repositorioDeVideo, RepositorioDeCategoria $repositorioDeCategoria)
    {
        $this->repositorioDeVideo = $repositorioDeVideo;
        $this->repositorioDeCategoria = $repositorioDeCategoria;
    }

    public function executa(AdicionarVideoDto $dados): Video
    {
        $video = Video::comTituloDescricaoUrlECategoria($dados->titulo, $dados->descricao, new Url($dados->url), $this->repositorioDeCategoria->buscarPorId($dados->categoria));
        return $this->repositorioDeVideo->adicionar($video);
    }
}