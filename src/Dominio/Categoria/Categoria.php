<?php

namespace src\Dominio\Categoria;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categorias")
 */
class Categoria implements \Stringable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /** @ORM\Column(type="string", nullable=false) */
    protected string $titulo;

    /** @ORM\Column(type="integer", nullable=false) */
    protected int $cor;

    public static function comTituloCorEId(string $titulo, Cor $cor, int $id = null): self
    {
        return new Categoria($titulo, $cor, $id);
    }

    private function __construct(string $titulo, Cor $cor, int $id = null)
    {
        if ($id) $this->id = $id;

        $this->titulo = $titulo;
        $this->cor = $cor->id();
    }

    public function id(): int
    {
        return $this->id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function cor():  int
    {
        return $this->cor;
    }

    public function corNome(): string
    {
        return $this->cor;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function setCor(int $cor): self
    {
        $this->cor = $cor;
        return $this;
    }

    public function __toString(): string
    {
        return $this->titulo;
    }
}