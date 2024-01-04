<?php

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = \src\Infra\EntityManager\EntityManagerCreator::create();

$password = 'admin';
$hash = password_hash($password, PASSWORD_ARGON2ID);

$admin = new \src\Dominio\Usuario\Usuario('Admin','admin@admin.com', $hash);

$entityManager->persist($admin);
$entityManager->flush();