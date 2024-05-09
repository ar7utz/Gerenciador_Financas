<?php
session_start();

include '../../assets/bd/conexao.php';

session_start();

include '../../assets/bd/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $valor = str_replace(',', '.', $_POST['valor']); // Substitui vírgula por ponto
    $valor = (float)$valor;
    $data = $_POST['data'];
    $usuario_id = $_SESSION['user_id'];
    $tipo = $_POST['tipo']; // Obter o tipo de transação (positivo ou negativo)

    if (empty($descricao) || empty($valor) || empty($data)) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Todos os campos são obrigatórios.']);
        exit;
    }

    if ($tipo === 'negativo') {
        $valor = -$valor;
    }

    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        $sql = "INSERT INTO transacoes (descricao, valor, data, usuario_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sdsi', $descricao, $valor, $data, $usuario_id);
        $stmt->execute();
        header("Location: ../dashboard/dashboard.php");
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'ID do usuário não encontrado na sessão.']);
        exit;
    }
    
    $stmt->close();
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método de solicitação inválido. Use POST.']);
}

$conn->close();


$conn->close();
?>
<script src="../../assets/js/main.js"></script>
