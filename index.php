<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $codigo_barras = $_POST['codigo_barras'];
    $quantidade = $_POST['quantidade'];
    
    // Tratamento do preço para aceitar vírgula ou ponto
    $preco_limpo = str_replace(',', '.', $_POST['preco']);
    $preco = preg_replace('/[^0-9.]/', '', $preco_limpo);

    $fornecedor = $_POST['fornecedor'];
    $data_recebimento = $_POST['data_recebimento'];

    $sql = "INSERT INTO produtos (nome, codigo_barras, quantidade, preco, fornecedor, data_recebimento) 
            VALUES ('$nome', '$codigo_barras', '$quantidade', '$preco', '$fornecedor', '$data_recebimento')";

    if ($conexao->query($sql) === TRUE) {
        echo "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro: " . $conexao->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Estoque</title>
</head>
<body>

    <h2>Cadastro de Produtos - Sistema de Estoque</h2>

    <form method="POST" action="">
        <label>Nome do Produto:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Código de Barras:</label><br>
        <input type="text" name="codigo_barras"><br><br>

        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" required><br><br>

        <label>Preço (R$):</label><br>
        <input type="text" name="preco" required><br><br>

        <label>Fornecedor:</label><br>
        <input type="text" name="fornecedor" required><br><br>

        <label>Data de Recebimento:</label><br>
        <input type="date" name="data_recebimento" required><br><br>
        
        <button type="submit">Cadastrar Produto</button>
    </form>

    <hr>
    <h3>Produtos Cadastrados</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cód. Barras</th>
            <th>Qtd</th>
            <th>Preço</th>
            <th>Fornecedor</th>
            <th>Data Recebimento</th>
            <th>Tempo no Armazém</th>
            <th>Ações</th>
        </tr>
        <?php
        $consulta = "SELECT * FROM produtos";
        $resultado = $conexao->query($consulta);

        if ($resultado->num_rows > 0) {
            while($linha = $resultado->fetch_assoc()) {
                // Calcula tempo no armazém se houver data cadastrada
                if (!empty($linha['data_recebimento'])) {
                    $data_entrada = new DateTime($linha['data_recebimento']);
                    $hoje = new DateTime();
                    $diferenca = $hoje->diff($data_entrada);
                    $tempo = $diferenca->days . " dias";
                } else {
                    $tempo = "Sem data";
                }

                echo "<tr>";
                echo "<td>" . $linha['id'] . "</td>";
                echo "<td>" . $linha['nome'] . "</td>";
                echo "<td>" . $linha['codigo_barras'] . "</td>";
                echo "<td>" . $linha['quantidade'] . "</td>";
                echo "<td>R$ " . number_format($linha['preco'], 2, ',', '.') . "</td>";
                echo "<td>" . $linha['fornecedor'] . "</td>";
                echo "<td>" . (!empty($linha['data_recebimento']) ? date('d/m/Y', strtotime($linha['data_recebimento'])) : '') . "</td>";
                echo "<td>" . $tempo . "</td>";
                echo "<td>
                        <a href='editar.php?id=" . $linha['id'] . "'>Editar</a> | 
                        <a href='excluir.php?id=" . $linha['id'] . "'>Excluir</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9' style='text-align:center;'>Nenhum produto cadastrado ainda.</td></tr>";
        }
        ?>
    </table>

</body>
</html>
