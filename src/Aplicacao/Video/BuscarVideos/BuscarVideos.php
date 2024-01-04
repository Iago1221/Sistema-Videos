<?php

namespace src\Aplicacao\Video\BuscarVideos;

use src\Dominio\Video\RepositorioDeVideo;

class BuscarVideos
{
    private RepositorioDeVideo $repositorioDeVideo;

    public function __construct(RepositorioDeVideo $repositorioDeVideo)
    {
        $this->repositorioDeVideo = $repositorioDeVideo;
    }

    /** @return \src\Dominio\Video\Video[] */
    public function executa(string $search = null, int $pagina)
    {
        return $this->repositorioDeVideo->buscarTodos($search, $pagina);
    }
}