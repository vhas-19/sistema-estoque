<?php
$servidor = "localhost";
$usuario = "usuario_estoque";
$senha = "hasthur";
$banco = "sistema_estoque";
$conexao = new mysqli($servidor, $usuario, $senha, $banco);
if ($conexao->connect_error) {
	die("Falha na conexão: " . $conexao->connect_error);
}
?>
