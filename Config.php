<?php
// Configurações do banco
$host = 'localhost';
$dbname = 'projetovida';
$user = 'root';
$password = '';

// Conexão MySQLi (orientado a objeto)
$mysqli = new mysqli($host, $user, $password, $dbname);
if ($mysqli->connect_error) {
    die('Erro de conexão MySQLi: ' . $mysqli->connect_error);
}

// Conexão PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro de conexão PDO: ' . $e->getMessage());
}

return $mysqli; // <-- ISSO AQUI É ESSENCIAL
?>
