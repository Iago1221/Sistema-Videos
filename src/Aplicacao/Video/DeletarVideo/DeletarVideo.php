<?php

namespace src\Aplicacao\Video\DeletarVideo;

use src\Dominio\Video\RepositorioDeVideo;

class DeletarVideo
{
    private RepositorioDeVideo $repositorioDeVideo;

    public function __construct(RepositorioDeVideo $repositorioDeVideo)
    {
        $this->repositorioDeVideo = $repositorioDeVideo;
    }

    public function executa(int $id): void
    {
        $this->repositorioDeVideo->deletar($id);
    }
}