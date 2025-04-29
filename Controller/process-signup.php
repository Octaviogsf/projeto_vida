<?php

if (empty($_POST["name"])) {
    die("Name is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

// Removido todas as validações de conteúdo da senha

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

if (empty($_POST["birthdate"])) {
    die("Date of birth is required");
}

// Armazena a senha com segurança
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . '/../Config.php';

$sql = "INSERT INTO user (name, email, birthdate, password_hash)
        VALUES (?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param(
    "ssss",
    $_POST["name"],
    $_POST["email"],
    $_POST["birthdate"],
    $password_hash
);

if ($stmt->execute()) {
    header("Location: ../View/signup-success.html");
    exit;
} else {
    if ($mysqli->errno === 1062) {
        die("Email already taken");
    } else {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
