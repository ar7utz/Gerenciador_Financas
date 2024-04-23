<?php
include ('../../assets/bd/conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="content-language" content="pt-BR" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/scrollbar.css" />

    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,400;0,700;1,100;1,400;1,700&display=swap"
      rel="stylesheet"
    />

    <title>Gerenciamento de Finanças</title>
  </head>
  <body>
    <header>
      <div class="container">
        <h1>Gerenciamento de Finanças</h1>
        <a href="../login/logout.php">sair</a> <!-- improvisado -->
        <button id="toggleModal">+ Nova Transação</button>
      </div>
    </header>
    <main>
      <div class="container">
        <div class="total">
        <h2>SALDO</h2>
        <p id="saldo">R$ 0,00</p>
        </div>
        <div class="entradas-saidas">
          <div class="card entradas">
            <h3>Entradas</h3>
            <p id="entradas">R$ 0,00</p>
          </div>
          <div class="card saidas">
            <h3>Saídas</h3>
            <p id="saidas">R$ 0,00</p>
          </div>
        </div>
        <div class="historico">
          <h2>Histórico</h2>
          <ul id="historico-list">
          <?php
            include ('../../assets/bd/conexao.php');

            // Consultar o banco de dados para obter todas as transações
            $sql = "SELECT * FROM transacoes WHERE usuario_id = ? ORDER BY data DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $usuario_id);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Verificar se há transações
            if ($resultado->num_rows > 0) {
                // Exibir as transações no histórico
                while ($row = $resultado->fetch_assoc()) {
                  echo '<li>';
                  echo '<span>' . $row['descricao'] . '</span>';
                  echo '<span>' . $row['data'] . '</span>';
                  echo '<span>' . $row['valor'] . '</span>';
                  echo '<button class="editar" ' . $row['id'] . '">Editar</button>';
                  echo '<button class="excluir" ' . $row['id'] . '">Excluir</button>';
                  echo '</li>';
                }
            } else {
                // Se não houver transações, exibir uma mensagem indicando que o histórico está vazio
                echo '<li>Nenhuma transação encontrada.</li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </main>
    <form action="../transacoes/add_transacao.php" method="POST" >
        <div class="modal-overlay" id="modal" >
            <div class="modal">
                <h2>Nova Transação</h2>
                <div class="tipoTransacao">
                    <select name="tipo" required>
                        <option value="positivo">Transação Positiva</option>
                        <option value="negativo">Transação Negativa</option>
                    </select>
                </div>
                <form id="novaTransacaoForm" method="POST" action="adicionarTransacao.php">
                    <input type="text" name="descricao" placeholder="Descrição" required>
                    <input type="number" name="valor" placeholder="Valor" required>
                    <input type="date" name="data" required>
                    <div class="botoes">
                        <button type="button" class="cancelar" id="fecharModal">Cancelar</button>
                        <button type="submit" class="confirmar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </form>

    <!-- Modal de confirmação de exclusão -->
    <div id="modalConfirmarExclusao" class="modal">
      <div class="modal-content">
        <p>Tem certeza de que deseja excluir esta nota?</p>
        <button id="confirmarExcluirNota">Confirmar</button>
        <button id="cancelarExcluirNota">Cancelar</button>
      </div>
    </div>

    <script src="../../assets/js/main.js"></script>
  </body>
</html>