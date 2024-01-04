<?php

namespace src\Dominio\Video;

use Doctrine\ORM\Mapping as ORM;
use src\Dominio\Categoria\Categoria;

/**
 * @ORM\Entity
 * @ORM\Table(name="videos")
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /** @ORM\Column(type="string", nullable=false) */
    protected string $url;

    /** @ORM\Column(type="string", nullable=false) */
    protected string $titulo;

    /** @ORM\Column(type="text", nullable=true) */
    protected string $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="src\Dominio\Categoria\Categoria", inversedBy="id")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id", nullable=false)
     */
    protected Categoria $categoria;

    public static function comTituloDescricaoUrlECategoria(string $titulo, string $descricao, Url $url, Categoria $categoria): self
    {
        return new Video($url, $titulo, $descricao, $categoria);
    }

    private function __construct(Url $url, string $titulo, string $descricao, Categoria $categoria)
    {
        $this->url = $url;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->categoria = $categoria;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function setUrl(Url $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setCategoria(Categoria $categoria): self
    {
        $this->categoria = $categoria;
        return $this;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function descricao(): string
    {
        return $this->descricao;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function categoria(): Categoria
    {
        return $this->categoria;
    }

    public function categoriaTitulo(): string
    {
        return $this->categoria;
    }
}