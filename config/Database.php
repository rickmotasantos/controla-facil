<?php

function conectarBanco()
{
    $envPath = __DIR__ . '/../.env';

    if (!file_exists($envPath)) {
        die("Arquivo .env não encontrado em: " . $envPath);
    }

    $env = parse_ini_file($envPath);

    $host = $env['DB_HOST'];
    $db   = $env['DB_NAME'];
    $user = $env['DB_USER'];
    $pass = $env['DB_PASS'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo; // 👈 IMPORTANTE
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}