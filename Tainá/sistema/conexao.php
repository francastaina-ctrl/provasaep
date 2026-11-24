<?php
$servidor = 'localhost';
$banco = 'clinica_veterinaria';
$usuario = 'root';
$senha = '';
$porta = 3307;

// Defina sua senha do banco aqui

try {
    $pdo = new PDO("mysql:host=$servidor;port=$porta;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria o banco caso não exista
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $banco");
    $pdo->exec("USE $banco");

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>