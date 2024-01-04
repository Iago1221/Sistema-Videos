<?php

namespace src\Dominio\Usuario;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id ;

    /** @ORM\Column(type="string", nullable=false) */
    protected string $nome ;

    /** @ORM\Column(type="string", nullable=false) */
    protected string $email ;

    /** @ORM\Column(type="string", nullable=false) */
    protected string $password ;

    public function __construct(string $nome, string $email, string $password)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->password = $password;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function nome(): string
    {
        return $this->nome;
    }

    public function email(): string
    {
        return $this->email;
    }


    public function password(): ?string
    {
        return $this->password;
    }
}
