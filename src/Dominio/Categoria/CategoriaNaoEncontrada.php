<?php

namespace src\Dominio\Categoria;

class CategoriaNaoEncontrada extends \DomainException
{
    public function __construct(int $id)
    {
        parent::__construct("Categoria com Id $id não encontrada");
    }
}