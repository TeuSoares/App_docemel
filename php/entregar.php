<?php
header("Access-Control-Allow-Origin:*");
date_default_timezone_set('America/Sao_Paulo');

// Incluir conexao
include ("funcoes2.php");

$id_usuario = $_POST["id_usuario"];   
$data = date("Y-m-d");

$SQL = "UPDATE encomendas SET realizarPedido = 'Entregar' WHERE fk_id_usuario = $id_usuario and situacao = 'Aguardando' and data = '$data' ";

if($conexao->query($SQL)){
  echo  $sql;
}else{
  echo  $sql;
}

?>