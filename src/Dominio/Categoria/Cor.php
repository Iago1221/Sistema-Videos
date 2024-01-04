<?php

namespace src\Dominio\Categoria;

class Cor implements \Stringable
{
    CONST COR_PRETO = 0;
    CONST COR_BRANCO = 1;
    CONST COR_VERMELHO = 2;
    CONST COR_AMARELO = 3;
    CONST COR_VERDE = 4;
    CONST COR_AZUL = 5;

    protected int $id;

    public function __construct(int $id)
    {
        $this->setId($id);
    }

    protected function setId(int $id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->corEnumerator()[$this->id];
    }

    public function corEnumerator()
    {
        return [
            self::COR_PRETO =>  'Preto',
            self::COR_BRANCO => 'Branco',
            self::COR_VERMELHO => 'Vermelho',
            self::COR_AMARELO => 'Amarelo',
            self::COR_VERDE => 'Verde',
            self::COR_AZUL => 'Azul',
        ];
    }
}