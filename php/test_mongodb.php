<?php
require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

$client = new Client("mongodb+srv://linkfreeAdmin:fecBWWffO5RBDliz@linkfree.ldgpqbw.mongodb.net/");
$db = $client->LinkFree_Dates; // substitua pelo nome do seu banco
$collection = $db->Users; // substitua pelo nome da coleção

$result = $collection->insertOne([
    'nome' => 'João',
    'email' => 'joao@example.com'
]);

echo "Documento inserido com ID: " . $result->getInsertedId();
?>