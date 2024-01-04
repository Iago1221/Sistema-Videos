<?php

namespace src\Infra;

use src\Infra\EntityManager\EntityManagerCreator;
use src\Infra\public\Autenticator;

class LoginController
{
    public function processaLogin()
    {
        $request = $this->getRequest();
        $login = $request['username'] ?? '';
        $password = $request['password'] ?? '';

        $entityManager = EntityManagerCreator::create();
        $autenticator = new Autenticator($login, $password);
        $result = $autenticator->generateToken();

        return $result;
    }

    protected function getRequest() {
        $request = file_get_contents('php://input');
        $requestData = json_decode($request, true);
        return $requestData;
    }
}