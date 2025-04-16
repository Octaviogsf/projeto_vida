<?php
$mysqli = require __DIR__ . '/../Config.php';

if (!isset($_GET['email'])) {
    echo json_encode(["success" => false, "message" => "No email provided"]);
    exit;
}

$email = $_GET['email'];

$sql = "SELECT id FROM user WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email já cadastrado"]);
} else {
    echo json_encode(["success" => true]);
}
