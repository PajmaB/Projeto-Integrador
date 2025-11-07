<?php
require 'db_connect.php';

// Recebe os dados do formulário
$data = json_decode(file_get_contents("php://input"), true);

$nome = $data['nome'] ?? '';
$email = $data['email'] ?? '';
$senha = $data['senha'] ?? '';
$tipo = $data['tipo'] ?? '';

if (!$nome || !$email || !$senha || !$tipo) {
    echo json_encode(["error" => "Preencha todos os campos!"]);
    exit;
}

// Define a coleção conforme o tipo de conta
$collectionName = ($tipo === "empresa") ? "Enterprises" : "Users";

// Seleciona a coleção dinamicamente
$collection = $database->selectCollection($collectionName);

// Verifica se o e-mail já existe
$existingUser = $collection->findOne(["email" => $email]);

if ($existingUser) {
    echo json_encode(["error" => "Email já cadastrado nesta categoria."]);
    exit;
}

// Cria o novo registro
$hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

$newUser = [
    "nome" => $nome,
    "email" => $email,
    "senha" => $hashedPassword
];

$collection->insertOne($newUser);

echo json_encode(["message" => "Conta cadastrada com sucesso na coleção '$collectionName'!"]);
?>
