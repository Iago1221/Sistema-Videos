<?php

namespace src\Aplicacao\Video\AtualizarVideo;

use src\Dominio\Categoria\RepositorioDeCategoria;
use src\Dominio\Video\RepositorioDeVideo;
use src\Dominio\Video\Url;
use src\Dominio\Video\Video;

class AtualizarVideo
{
    private RepositorioDeVideo $repositorioDeVideo;
    private RepositorioDeCategoria $repositorioDeCategoria;

    public function __construct(RepositorioDeVideo $repositorioDeVideo, RepositorioDeCategoria $repositorioDeCategoria)
    {
        $this->repositorioDeVideo = $repositorioDeVideo;
        $this->repositorioDeCategoria = $repositorioDeCategoria;
    }

    public function executa(AtualizarVideoDto $dados, Video $video): Video
    {
        $video->setTitulo($dados->titulo)
              ->setDescricao($dados->descricao)
              ->setUrl(new Url($dados->url))
              ->setCategoria($this->repositorioDeCategoria->buscarPorId($dados->categoria));

        return $this->repositorioDeVideo->atualizar($video);
    }
}