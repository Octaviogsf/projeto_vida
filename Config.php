<?php
$mysqli = new mysqli("localhost", "root", "", "projetovida");

if ($mysqli->connect_error) {
    die("Erro na conexão: " . $mysqli->connect_error);
}

return $mysqli;
