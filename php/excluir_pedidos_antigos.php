<?php
header("Content-type: application/json");
header("Access-Control-Allow-Origin:*");

// Incluir conexao
include ("conf/conexao2.php");
$conexao = con_mysql();

$id_usuario = $_POST["id_usuario"];

$SQLdelete = $conexao->query("DELETE FROM encomendas WHERE fk_id_usuario = $id_usuario and data = DATE_SUB(CURDATE(),INTERVAL 1 DAY) and situacao = 'Aguardando' ");
echo "Sucesso";

?>