<?php

namespace src\Infra\Categoria;

use src\Dominio\Categoria\Categoria;
use src\Dominio\Categoria\CategoriaNaoEncontrada;
use src\Dominio\Categoria\RepositorioDeCategoria;

class RepositorioDeCategoriaComDoctrine implements RepositorioDeCategoria
{
    private \Doctrine\ORM\EntityManager $_em;

    public function __construct(\Doctrine\ORM\EntityManager $conexao)
    {
        $this->_em = $conexao;
    }

    public function adicionar(Categoria $categoria): Categoria
    {
        $this->_em->persist($categoria);
        $this->_em->flush();

        return $this->buscarPorId($categoria->id());
    }

    public function buscarPorId(int $id): Categoria
    {
        $categoria = $this->_em->find(Categoria::class, $id);

        if (!$categoria) throw new CategoriaNaoEncontrada($id);

        return $categoria;
    }

    public function buscarTodas(int $pagina): array
    {
        $limit = 5;
        $pagina = ($pagina - 1) * $limit;
        return $this->_em->getRepository(Categoria::class)->findBy([], ['id' => 'ASC'], $limit, $pagina);
    }

    public function deletar(int $id): void
    {
        $this->_em->remove($this->buscarPorId($id));
        $this->_em->flush();
    }

    public function atualizar(Categoria $categoria): Categoria
    {
        $this->_em->persist($categoria);
        $this->_em->flush();

        return $this->buscarPorId($categoria->id());
    }
}