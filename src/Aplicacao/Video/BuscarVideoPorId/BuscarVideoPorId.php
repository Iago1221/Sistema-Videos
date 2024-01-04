<?php

namespace src\Aplicacao\Video\BuscarVideoPorId;

use src\Dominio\Video\RepositorioDeVideo;
use src\Dominio\Video\Video;

class BuscarVideoPorId
{
    private RepositorioDeVideo $repositorioDeVideo;

    public function __construct(RepositorioDeVideo $repositorioDeVideo)
    {
        $this->repositorioDeVideo = $repositorioDeVideo;
    }

    public function executa(int $id): Video
    {
        return $this->repositorioDeVideo->buscarPorId($id);
    }
}