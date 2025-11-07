<?php
require 'db_connect.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$senha = $data['senha'] ?? '';
$tipo = $data['tipo'] ?? '';

if (!$email || !$senha || !$tipo) {
    echo json_encode(["error" => "Preencha todos os campos!"]);
    exit;
}

// Escolhe a coleção correta
$collectionName = ($tipo === "empresa") ? "Enterprises" : "Users";
$collection = $database->selectCollection($collectionName);

// Procura o usuário pelo email
$user = $collection->findOne(["email" => $email]);

if (!$user) {
    echo json_encode(["error" => "Usuário não encontrado."]);
    exit;
}

// Verifica a senha
if (!password_verify($senha, $user['senha'])) {
    echo json_encode(["error" => "Senha incorreta."]);
    exit;
}

// Login OK
echo json_encode(["success" => true, "message" => "Login realizado com sucesso!"]);
?>
