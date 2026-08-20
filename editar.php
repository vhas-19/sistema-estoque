<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $codigo_barras = $_POST['codigo_barras'];
    $quantidade = $_POST['quantidade'];

    $preco_limpo = str_replace(',', '.', $_POST['preco']);
    $preco = preg_replace('/[^0-9.]/', '', $preco_limpo);

    $fornecedor = $_POST['fornecedor'];
    $data_recebimento = $_POST['data_recebimento'];

    $sql = "UPDATE produtos SET
            nome='$nome',
            codigo_barras='$codigo_barras',
            quantidade='$quantidade',
            preco='$preco',
            fornecedor='$fornecedor',
            data_recebimento='$data_recebimento'
            WHERE id=$id";

    if ($conexao->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar: " . $conexao->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $resultado = $conexao->query("SELECT * FROM produtos WHERE id = $id");
    $produto = $resultado->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h2>Editar Produto</h2>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

        <label>Nome do Produto:</label><br>
        <input type="text" name="nome" value="<?php echo $produto['nome']; ?>" required><br><br>

        <label>Código de Barras:</label><br>
        <input type="text" name="codigo_barras" value="<?php echo $produto['codigo_barras']; ?>"><br><br>

        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" value="<?php echo $produto['quantidade']; ?>" required><br><br>

        <label>Preço (R$):</label><br>
        <input type="text" name="preco" value="<?php echo $produto['preco']; ?>" required><br><br>

        <label>Fornecedor:</label><br>
        <input type="text" name="fornecedor" value="<?php echo $produto['fornecedor']; ?>" required><br><br>

        <label>Data de Recebimento:</label><br>
        <input type="date" name="data_recebimento" value="<?php echo $produto['data_recebimento']; ?>" required><br><br>

        <button type="submit">Salvar Alterações</button>
        <a href="index.php">Cancelar</a>
    </form>
</body>
</html>
