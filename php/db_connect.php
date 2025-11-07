<?php
require __DIR__ . '/../vendor/autoload.php'; // carrega o driver

use MongoDB\Client;

try {
    // Conexão com o MongoDB Atlas
    $client = new Client("mongodb+srv://linkfreeAdmin:fecBWWffO5RBDliz@linkfree.ldgpqbw.mongodb.net/");

    // Seleciona o banco de dados
    $database = $client->selectDatabase("LinkFree_Dates");

} catch (Exception $e) {
    die(json_encode(["error" => "Erro ao conectar ao MongoDB: " . $e->getMessage()]));
}
?>
