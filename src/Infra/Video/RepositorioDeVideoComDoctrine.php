<?php

namespace src\Infra\Video;

use src\Dominio\Categoria\Categoria;
use src\Dominio\Video\RepositorioDeVideo;
use src\Dominio\Video\Video;
use src\Dominio\Video\VideoNaoEncontrado;

class RepositorioDeVideoComDoctrine implements RepositorioDeVideo
{
    private \Doctrine\ORM\EntityManager $_em;

    public function __construct(\Doctrine\ORM\EntityManager $conexao)
    {
        $this->_em = $conexao;
    }

    public function adicionar(Video $video): Video
    {
        $this->_em->persist($video);
        $this->_em->flush();

        return $this->buscarPorId($video->id());
    }

    public function buscarPorId(int $id): Video
    {
        $video = $this->_em->find(Video::class, $id);

        if (!$video) throw new VideoNaoEncontrado($id);

        return $video;
    }

    public function buscarTodos(string $search = null, int $pagina): array
    {
        $limit = 5;
        $pagina = ($pagina - 1) * $limit;

        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('video')
            ->from('src\Dominio\Video\Video', 'video')
            ->orderBy('video.id', 'asc')
            ->setMaxResults($limit)
            ->setFirstResult($pagina);

        if ($search) {
            $queryBuilder->where($queryBuilder->expr()->like('video.titulo', ':titulo'))
                ->setParameter('titulo', '%' . $search . '%');
        }

         return $queryBuilder->getQuery()->getResult();
    }

    public function deletar(int $id): void
    {
        $this->_em->remove($this->buscarPorId($id));
        $this->_em->flush();
    }

    public function atualizar(Video $video): Video
    {
        $this->_em->persist($video);
        $this->_em->flush();

        return $this->buscarPorId($video->id());
    }

    public function buscarVideosPorCategoria(Categoria $categoria, int $pagina): array
    {
        $limit = 5;
        $pagina = ($pagina - 1) * $limit;
        return $this->_em->getRepository(Video::class)->findBy(['categoria' => $categoria], ['id' => 'ASC'],
            $limit,
            $pagina);
    }
}