<?php

namespace src\Infra\public;

use Doctrine\ORM\EntityManager;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use src\Aplicacao\Response;
use src\Dominio\Usuario\Usuario;
use src\Infra\EntityManager\EntityManagerCreator;

class Autenticator
{
    private string $login;
    private string $password;
    private EntityManager $entityManager;

    public function __construct(string $login, string $password)
    {
        $this->login = $login;
        $this->password = $password;
        $this->entityManager = EntityManagerCreator::getEntityManager();
    }

    public function login(): bool
    {
        $user = $this->entityManager->getRepository(Usuario::class)->findOneBy([
            'email' => $this->login
        ]);
        if (!$user) return false;

        return (password_verify($this->password, $user->password()));
    }

    public function generateToken()
    {
        if(!$this->login()) Response::error('Unauthorized', 401);

        $dadosToken = [
            "usuario" => $this->login,
            "tempo_de_expiracao" => time() + 14400
        ];

        $token = JWT::encode($dadosToken, self::getSecretForLogin($this->login), 'HS256');
        return $token;
    }

    public static function verifyToken()
    {
        $token = self::getTokenFromHeader();

        if (!$token) Response::error('Unauthorized', 401);

        $token_parts = explode('.', $token);
        $payload_base64 = $token_parts[1];
        $payload_json = base64_decode($payload_base64);
        $payload_data = json_decode($payload_json, true);

        $secret = self::getSecretForLogin($payload_data['usuario']);
        if (self::validateToken($token, $secret)) return true;

        Response::error('Unauthorized', 401);
    }

    private static function getTokenFromHeader()
    {
        $headers = getallheaders();
        if (isset($headers['oasys-token'])) {
            $token = $headers['oasys-token'];
            return $token;
        }
        return null;
    }

    private static function validateToken($token, $secret)
    {
        $jwtKey = new Key($secret, 'HS256');
        $options = new \stdClass();
        $options->algorithm = 'HS256';

        try {
            $decoded = \Firebase\JWT\JWT::decode($token, $jwtKey, $options);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private static function getSecretForLogin($login): string
    {
        $_em = EntityManagerCreator::getEntityManager();
        $usuario = $_em->getRepository(Usuario::class)->findOneBy([
            'email' => $login
        ]);

        return $usuario->id() . $usuario->password();
    }
}