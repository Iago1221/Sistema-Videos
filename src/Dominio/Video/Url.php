<?php

namespace src\Dominio\Video;

class Url implements \Stringable
{
    protected string $endereco;

    public function __construct(string $endereco)
    {
        $this->setEndereco($endereco);
    }

    protected function setEndereco(string $endereco)
    {
        $this->endereco = $endereco;
    }

    public function __toString(): string
    {
        return $this->endereco;
    }
}