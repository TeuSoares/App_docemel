<?php
header("Content-type: application/json");
header("Access-Control-Allow-Origin:*");

// Incluir conexao
include ("conf/conexao2.php");
$conexao = con_mysql();

$id_pedido = $_POST["id_pedido"]; 
$id_usuario = $_POST["id_usuario"];

$SQLdelete = $conexao->query("DELETE FROM encomendas WHERE id_pedido = $id_pedido and fk_id_usuario = $id_usuario ");
echo "Sucesso";

?>