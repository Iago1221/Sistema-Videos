<?php

namespace src\Infra\Video;

use src\Aplicacao\Response;
use src\Dominio\Video\RepositorioDeVideo;
use src\Dominio\Video\Video;

class VideoController extends \src\Infra\Controller
{
    private RepositorioDeVideo $repositorioDeVideo;
    private $_em;
    public function __construct()
    {
        $this->_em = \src\Infra\EntityManager\EntityManagerCreator::getEntityManager();
        $this->repositorioDeVideo = new \src\Infra\Video\RepositorioDeVideoComDoctrine($this->_em);
    }

    public function getAll(): void
    {
        $seach = $_GET['search'] ?? null;
        $pagina = (int) $_GET['page'];
        if (!$pagina) $pagina = 1;
        $buscador = new \src\Aplicacao\Video\BuscarVideos\BuscarVideos($this->getRepositorio());
        $videos = $buscador->executa($seach, $pagina);
        $data = [];

        foreach ($videos as $video) {
            $data[] = self::mapEntityToArray($video);
        }

        Response::success($data);
    }

    public function getForId(int $id): void
    {
        try {
            $buscador = new \src\Aplicacao\Video\BuscarVideoPorId\BuscarVideoPorId($this->getRepositorio());
            $video = $buscador->executa($id);
            $video = self::mapEntityToArray($video);
            Response::success($video);
        }catch (\Throwable $t) {
            Response::error($t->getMessage());
        }
    }

    public function update(int $id): void
    {
        try {
            $video = $this->getRepositorio()->buscarPorId($id);
            $dto = $this->montaVideo($video);
            $repositorioCategoria = new \src\Infra\Categoria\RepositorioDeCategoriaComDoctrine($this->_em);
            $atualizador = new \src\Aplicacao\Video\AtualizarVideo\AtualizarVideo($this->getRepositorio(), $repositorioCategoria);
            $video = $atualizador->executa($dto, $video);
            $video = self::mapEntityToArray($video);
            Response::success($video);
        }catch (\Throwable $t) {
            Response::error($t->getMessage());
        }
    }

    public function add(): void
    {
        try {
            $dados = $this->getRequest();
            $this->validaDados($dados);
            $dados['categoria'] = $dados['categoria'] ?? 1;
            $dto = new \src\Aplicacao\Video\AdicionarVideo\AdicionarVideoDto($dados['titulo'], $dados['descricao'], $dados['url'], $dados['categoria']);
            $repositorioCategoria = new \src\Infra\Categoria\RepositorioDeCategoriaComDoctrine($this->_em);
            $adicionador = new \src\Aplicacao\Video\AdicionarVideo\AdicionarVideo($this->getRepositorio(), $repositorioCategoria);
            $video = $adicionador->executa($dto);
            $video = self::mapEntityToArray($video);
            Response::success($video);
        }catch (\Throwable $t){
            Response::error($t->getMessage());
        }
    }

    public function delete(int $id): void
    {
        try {
            $deletador = new \src\Aplicacao\Video\DeletarVideo\DeletarVideo($this->getRepositorio());
            $deletador->executa($id);
            Response::success('Sucesso ao deletar video!');
        }catch (\Throwable $t) {
            Response::error($t->getMessage());
        }
    }

    public function getVideosPorCategoria(int $categoriaId): void
    {
        try{
            $pagina = (int) $_GET['page'];
            if (!$pagina) $pagina = 1;

            $repositorioDeCategoria = new \src\Infra\Categoria\RepositorioDeCategoriaComDoctrine($this->_em);
            $categoria = $repositorioDeCategoria->buscarPorId($categoriaId);
            $videos = $this->getRepositorio()->buscarVideosPorCategoria($categoria, $pagina);
            $data = [];

            foreach ($videos as $video) {
                $data[] = self::mapEntityToArray($video);
            }

            Response::success($data);
        } catch (\Throwable $t){
            Response::error($t->getMessage());
        }
    }

    protected function getRepositorio(): RepositorioDeVideo
    {
        return $this->repositorioDeVideo;
    }

    public function getVideosFree()
    {
        $buscador = new \src\Aplicacao\Video\BuscarVideos\BuscarVideos($this->getRepositorio());
        $videos = $buscador->executa(null, 1);
        $data = [];

        foreach ($videos as $video) {
            $data[] = self::mapEntityToArray($video);
        }

        Response::success($data);
    }

    protected function montaVideo(Video $video)
    {
        $dados['titulo'] = $video->titulo();
        $dados['descricao'] = $video->descricao();
        $dados['url'] = $video->url();
        $dados['categoria'] = $video->categoria()->id();

        $this->validaDados($this->getRequest());

        foreach ($this->getRequest() as $i => $dado) {
            $dados[$i] = $dado;
        }

        return new \src\Aplicacao\Video\AtualizarVideo\AtualizarVideoDto($video->id(), $dados['titulo'], $dados['descricao'], $dados['url'], $dados['categoria']);
    }

    protected function validaDados($dados)
    {
        foreach ($dados as $i => $dado) {
            if ($i != 'titulo' && $i != 'descricao' && $i != 'url' && $i != 'categoria') {
                throw new \InvalidArgumentException('Dados inválidos!');
            }
        }
    }
}