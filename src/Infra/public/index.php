<?php

require_once '../../../vendor/autoload.php';

\src\Infra\public\IndexController::setHeaders();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    \src\Infra\public\IndexController::setOptionsHeaders();
}

\src\Infra\public\IndexController::processaRequisicao();