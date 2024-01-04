<?php

namespace src\Infra\Categoria;

use src\Aplicacao\Response;
use src\Dominio\Categoria\Categoria;
use src\Dominio\Categoria\RepositorioDeCategoria;

class CategoriaController extends \src\Infra\Controller
{
    private RepositorioDeCategoria $repositorioDeCategoria;
    private $_em;
    public function __construct()
    {
        $this->_em = \src\Infra\EntityManager\EntityManagerCreator::getEntityManager();
        $this->repositorioDeCategoria = new RepositorioDeCategoriaComDoctrine($this->_em);
    }

    public function getAll(): void
    {
        $pagina = (int) $_GET['page'];
        if (!$pagina) $pagina = 1;
        $buscador = new \src\Aplicacao\Categoria\BuscarCategorias\BuscarCategorias($this->getRepositorio());
        $videos = $buscador->executa($pagina);
        $data = [];

        foreach ($videos as $video) {
            $data[] = self::mapEntityToArray($video);
        }

        Response::success($data);
    }

    public function getForId(int $id): void
    {
        try {
            $buscador = new \src\Aplicacao\Categoria\BuscarCategoriaPorId\BuscarCategoriaPorId($this->getRepositorio());
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
            $categoria = $this->getRepositorio()->buscarPorId($id);
            $dto = $this->montaCategoria($categoria);
            $atualizador = new \src\Aplicacao\Categoria\AtualizarCategoria\AtualizarCategoria($this->getRepositorio());
            $video = $atualizador->executa($dto, $categoria);
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
            $dto = new \src\Aplicacao\Categoria\AdicionarCategoria\AdicionarCategoriaDto($dados['titulo'], $dados['cor']);
            $adicionador = new \src\Aplicacao\Categoria\AdicionarCategoria\AdicionarCategoria($this->getRepositorio());
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
            $deletador = new \src\Aplicacao\Categoria\DeletarCategoria\DeletarCategoria($this->getRepositorio());
            $deletador->executa($id);
            Response::success('Sucesso ao deletar categoria!');
        }catch (\Throwable $t) {
            Response::error($t->getMessage());
        }
    }

    protected function getRepositorio(): RepositorioDeCategoria
    {
        return $this->repositorioDeCategoria;
    }

    protected function montaCategoria(Categoria $categoria)
    {
        $dados['titulo'] = $categoria->titulo();
        $dados['cor'] = $categoria->cor();

        $this->validaDados($this->getRequest());

        foreach ($this->getRequest() as $i => $dado) {
            $dados[$i] = $dado;
        }

        return new \src\Aplicacao\Categoria\AtualizarCategoria\AtualizarCategoriaDto($categoria->id(), $dados['titulo'], $dados['cor']);
    }

    protected function validaDados($dados)
    {
        foreach ($dados as $i => $dado) {
            if ($i != 'titulo' && $i != 'cor') {
                throw new \InvalidArgumentException('Dados inválidos!');
            }
        }
    }
}