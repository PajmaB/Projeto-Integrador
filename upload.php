<?php
// Força o cabeçalho HTTP para UTF-8
header("Content-Type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");

echo('<html><head><meta charset="utf-8"></head>');

// Aumenta o tempo limite de execução
set_time_limit(300);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo('<body>');
    $vaga = $_POST['vaga'];
    $uploadDir = "uploads/";

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    echo "<h1>Resultados da Análise</h1>";
    echo "<hr>";

    if (isset($_FILES['curriculos']) && is_array($_FILES['curriculos']['tmp_name'])) {
        foreach ($_FILES['curriculos']['tmp_name'] as $key => $tmp_name) {
            $fileName = basename($_FILES['curriculos']['name'][$key]);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                echo "<h2>Currículo: $fileName</h2>";
                echo "<p>Enviado com sucesso. Iniciando análise...</p>";

                $python_executable = "py"; 
                $python_script = "analise_curriculo.py";

                $escaped_vaga = escapeshellarg($vaga);
                $escaped_file = escapeshellarg($targetFile);

                $command = "{$python_executable} {$python_script} {$escaped_vaga} {$escaped_file}";

                $output = [];
                $return_var = null;
                exec($command, $output, $return_var);

                if ($return_var === 0) {
                    echo "<pre>";
                    // garante saída UTF-8
                    foreach ($output as $line) {
                        echo htmlspecialchars($line, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") . "<br>";
                    }
                    echo "</pre>";
                } else {
                    echo "<p style='color: red;'>Erro ao executar o script de análise. Código de retorno: {$return_var}</p>";
                    echo "<pre>";
                    foreach ($output as $line) {
                        echo htmlspecialchars($line, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") . "<br>";
                    }
                    echo "</pre>";
                }

                echo "<hr>";
            } else {
                echo "<p style='color: red;'>Erro ao enviar $fileName.</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>Nenhum arquivo enviado.</p>";
    }
} else {
    echo "<p>Método de requisição inválido.</p>";
}
echo('</body></html>');
?>
