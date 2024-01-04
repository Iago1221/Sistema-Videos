<?php

namespace src\Dominio\Video;

class VideoNaoEncontrado extends \DomainException
{
    public function __construct(int $id)
    {
        parent::__construct("Video com Id $id não encontrado");
    }
}