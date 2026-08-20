<?php
include 'conexao.php';

if (isset($_GET['id'])) {
	$id = $_GET['id'];

	$sql = "DELETE FROM produtos WHERE id = $id";

	if ($conexao->query($sql) === TRUE) {
		header("Location: index.php");
		exit();
	} else {
		echo "Erro ao excluir produto: " . $conexao->error;
	}
}
?>
